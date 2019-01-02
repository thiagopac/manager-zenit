<?php

class Invoice extends ActiveRecord\Model
{
    public static $belongs_to = [
    ['company'],
    ['project']
    ];
    public static $has_many = [
    ['invoice_has_items'],
    ['invoice_has_payments'],
    ['items', 'through' => 'invoice_has_items']
    ];

    /**
    ** Get sum of income for given year
    ** return object
    **/
    public static function totalIncomeForYear($year)
    {
        $income = Invoice::find_by_sql("SELECT 
            SUM(`sum`) as summary
        FROM
            ((SELECT 
                SUM(`sum`) AS `sum`
            FROM
                invoices
            WHERE
                `status` = 'Paid' 
            AND 
                `paid` = '0'
            AND 
                paid_date BETWEEN '$year-01-01' AND '$year-12-31'
            ) 
            UNION ALL (SELECT 
                SUM(T3.`amount`) AS `sum`
            FROM
                invoice_has_payments AS T3
            LEFT JOIN
                invoices AS T4
            ON 
                T3.invoice_id = T4.id  
            WHERE 
                (T4.`status` = 'PartiallyPaid' OR (T4.`status` = 'Paid' AND T4.`paid` != '0'))
                AND 
                T3.`date` 
                    BETWEEN '$year-01-01' AND '$year-12-31' 

            ) ) t1
                    ");

        return $income[0]->summary;
    }

    /**
    ** Get sum of payments grouped by Month for statistics
    ** return object
    **/

    /*
    public static function getStatisticForYear($year){
        $incomeStats = Invoice::find_by_sql("SELECT
            paid_date as paid_date,
            SUM(`sum`) AS summary
        FROM
            ((SELECT
                paid_date AS `paid_date`,
                `status`,
                SUM(`sum`) AS `sum`
            FROM
                invoices
            WHERE
                `status` = 'Paid' AND `paid` = '0'
            AND
                paid_date BETWEEN '$year-01-01' AND '$year-12-31'
            GROUP BY
            SUBSTR(`paid_date`, 1, 7)
            )
            UNION ALL (SELECT
                T3.`date` AS `paid_date`,
                T4.`status`,
                SUM(T3.`amount`) AS `sum`
            FROM
                invoice_has_payments AS T3
            LEFT JOIN
                invoices AS T4
            ON
                T3.invoice_id = T4.id
            WHERE
                (T4.`status` = 'PartiallyPaid' OR (T4.`status` = 'Paid' AND T4.`paid` != '0'))
                AND
                T3.`date` BETWEEN '$year-01-01' AND '$year-12-31'
            GROUP BY
                SUBSTR(T3.`date`, 1, 7)
            ) )t1
            GROUP BY
                SUBSTR(`paid_date`, 1, 7);
            ");

    return $incomeStats;
    }
*/
    public static function getStatisticForYear($year)
    {
        $incomeStats = Invoice::find_by_sql("SELECT 
            SUBSTR(`paid_date`, 1, 7) as `paid_date`, 
            SUM(`summary`) AS `summary`
        FROM
            ((SELECT 
                SUBSTR(`paid_date`, 1, 7) AS `paid_date`, 
                SUM(`sum`) AS `summary`
            FROM
                invoices
            WHERE
                `status` = 'Paid' 
            AND 
                `paid` = '0'
            AND 
                `paid_date` BETWEEN '$year-01-01' AND '$year-12-31'
            GROUP BY 
            `paid_date`
            ) 
            UNION ALL (SELECT 
                SUBSTR(T3.`date`, 1, 7) AS `paid_date`, 
                SUM(T3.`amount`) AS `summary`
            FROM
                invoice_has_payments AS T3
            LEFT JOIN
                invoices AS T4
            ON 
                T3.invoice_id = T4.id  
            WHERE 
                (T4.`status` = 'PartiallyPaid' OR (T4.`status` = 'Paid' AND T4.`paid` != '0'))
                AND 
                T3.`date` BETWEEN '$year-01-01' AND '$year-12-31' 
            GROUP BY 
                SUBSTR(T3.`date`, 1, 7)
            ) )t1 
            GROUP BY 
                t1.`paid_date`;
            ");

        return $incomeStats;
    }

    /**
       ** Get sum of payments grouped by Month for statistics
       ** return object
       **/
    public static function getExpensesStatisticForYear($year)
    {
        $expensesByMonth = Expense::find_by_sql("SELECT 
                SUBSTR(`date`, 1, 7) as `date_month`,
                SUM(`value`) AS summary
            FROM 
                `expenses` 
            WHERE 
                `date` BETWEEN '$year-01-01' AND '$year-12-31' 
            Group BY 
                SUBSTR(`date`, 1, 7)
            ");

        return $expensesByMonth;
    }

    /**
    ** Get sum of payments grouped by Month for statistics
    ** return object
    **/
    public static function getExpensesStatisticFor($start, $end)
    {
        $expensesByMonth = Expense::find_by_sql("SELECT 
                SUBSTR(`date`, 1, 7) as `date_month`,
                SUM(`value`) AS summary
            FROM 
                `expenses` 
            WHERE 
                `date` BETWEEN '$start' AND '$end' 
            Group BY 
                SUBSTR(`date`, 1, 7)
            ");

        return $expensesByMonth;
    }

    /**
    ** Get sum of payments made in the given Month
    ** return object
    **/
    public static function paymentsForMonth($yearMonth)
    {
        $Paid = Invoice::find_by_sql("SELECT 
            SUM(`sum`) as summary
        FROM
            ((SELECT 
                SUM(`sum`) AS `sum`
            FROM
                invoices
            WHERE
                `status` = 'Paid' 
            AND 
                `paid` = '0' 
            AND 
                paid_date BETWEEN '$yearMonth-01' AND '$yearMonth-31'
            Group By 
                `sum`
            ) 
            UNION ALL (SELECT 
                SUM(T3.`amount`) AS `sum`
            FROM
                invoice_has_payments AS T3
            LEFT JOIN
                invoices AS T4
            ON 
                T3.invoice_id = T4.id  
            WHERE 
                (T4.`status` = 'PartiallyPaid' OR (T4.`status` = 'Paid' AND T4.`paid` != '0'))
                AND 
                T3.`date` BETWEEN '$yearMonth-01' AND '$yearMonth-31'  
            GROUP BY 
                `sum`
            ) ) t1
            ");

        return $Paid[0]->summary;
    }

    /**
    ** Get sum of outstanding payments
    ** return object
    **/
    public static function outstandingPayments($yearMonth = false)
    {
        $where = '';
        if ($yearMonth) {
            $where = " AND due_date BETWEEN '$yearMonth-01' AND '$yearMonth-31'";
        }
        $open = Invoice::find_by_sql("SELECT 
                sum(invoices.`sum`) as `summary` 
            FROM 
                invoices 
            WHERE 
                (invoices.`status` = 'Sent' 
            OR 
                invoices.`status` = 'Open') 
            AND 
                invoices.`estimate` != 1
            $where 
            ");

        $partially = Invoice::find_by_sql("SELECT 
                sum(invoices.`outstanding`) as summary 
            FROM 
                invoices 
            WHERE 
                invoices.`status` = 'PartiallyPaid'
            $where;
            ");
        $open[0]->summary = $open[0]->summary + $partially[0]->summary;
        return $open[0]->summary;
    }

    /**
    ** Get sum of outstanding payments
    ** return object
    **/
    public static function totalExpensesForYear($year)
    {
        $expenses = Expense::find_by_sql("SELECT 
                SUM(`value`) AS summary
            FROM 
                `expenses` 
            WHERE 
                `date` BETWEEN '$year-01-01' AND '$year-12-31' 
            ");

        return $expenses[0]->summary;
    }

    public static function overdueByDate($comp_array, $date)
    {
        $filter = '';
        if ($comp_array != false) {
            $filter = ' company_id in (' . $comp_array . ') AND ';
        }
        $invoices = Invoice::find_by_sql("SELECT 
                `reference`, 
                `id`, 
                `due_date` 
            FROM 
                `invoices`
            WHERE 
                    $filter

                    `status` != 'Paid'
                AND 
                    `status` != 'Canceled' 
                AND 
                    `due_date` < '$date' AND `estimate` != 1 ORDER BY `due_date` 
                
            ");

        return $invoices;
    }

    /**
    ** Get sum of payments grouped by Month for statistics
    ** return object
    **/
    public static function getStatisticFor($start, $end)
    {
        $incomeStats = Invoice::find_by_sql("SELECT 
            SUBSTR(paid_date, 1, 7) as paid_date, 
            SUM(`sum`) AS summary
        FROM
            ((SELECT 
                paid_date AS `paid_date`, 
                SUM(`sum`) AS `sum`
            FROM
                invoices
            WHERE
                `status` = 'Paid'
            AND 
                `paid` = '0'
            AND 
                `estimate` != 1
            AND 
                paid_date BETWEEN '$start' AND '$end'
            GROUP BY 
            SUBSTR(`paid_date`, 1, 7), paid_date 
            ) 
            UNION ALL (SELECT 
                SUBSTR(T3.`date`, 1, 7) AS `paid_date`, 
                SUM(T3.`amount`) AS `sum`
            FROM
                invoice_has_payments AS T3
            JOIN
                invoices AS T4
            ON 
                T3.invoice_id = T4.id  
            WHERE 
                (T4.`status` = 'PartiallyPaid' OR (T4.`status` = 'Paid' AND T4.`paid` != '0'))
                AND 
                T3.`date` BETWEEN '$start' AND '$end' 
            GROUP BY 
                SUBSTR(T3.`date`, 1, 7)
            ) )t1 
            GROUP BY 
                SUBSTR(paid_date, 1, 7)
            ");

        return $incomeStats;
    }

    /**
    ** Get sum of all invoices grouped by Month for statistics
    ** return object
    **/
    public static function getIssueStatisticFor($start, $end)
    {
        $incomeStats = Invoice::find_by_sql("SELECT 
            SUBSTR(issue_date, 1, 7) as issue_date, 
            SUM(`sum`) AS summary
            FROM
                invoices
            WHERE
                `status` != 'Canceled'
            AND 
                `estimate` != 1
            AND 
                issue_date BETWEEN '$start' AND '$end'
            GROUP BY 
                SUBSTR(issue_date, 1, 7)
            ");

        return $incomeStats;
    }

    /**
    ** Get sum of payments grouped by Month for statistics
    ** return object
    **/
    public static function getStatisticForClients($start, $end)
    {
        $incomeStats = Invoice::find_by_sql("SELECT 
            company_id as `company_id`, 
            SUM(`sum`) AS summary
        FROM
            ((SELECT 
                company_id as `company_id`, 
                SUM(`sum`) AS `sum`
            FROM
                invoices
            WHERE
                `status` = 'Paid'
            AND 
                `estimate` != 1
            AND 
                paid_date BETWEEN '$start' AND '$end'
            GROUP BY 
            company_id
            ) 
            UNION ALL (SELECT 
                T4.company_id as `company_id`, 
                SUM(T3.`amount`) AS `sum`
            FROM
                invoice_has_payments AS T3
            LEFT JOIN
                invoices AS T4
            ON 
                T3.invoice_id = T4.id  
            WHERE 
                T4.`status` = 'PartiallyPaid' 
                AND 
                `estimate` != 1
                AND 
                T3.`date` BETWEEN '$start' AND '$end' 
            GROUP BY 
                T4.company_id
            ) )t1 
            GROUP BY 
                company_id
            ");

        return $incomeStats;
    }

    /**
    ** Cacluate sum for invoice
    ** return invoice object
    **/
    public static function calculateSum($invoice)
    {
        $core_settings = Setting::first();
        $sum = 0;

        foreach ($invoice->invoice_has_items as $item) {
            $sum = $sum + ($item->amount * $item->value);
        }

        if (substr($invoice->discount, -1) == '%') {
            $discount = sprintf('%01.2f', round(($sum / 100) * substr($invoice->discount, 0, -1), 2));
        } else {
            $discount = $invoice->discount;
        }

        $sum = $sum - $discount;
        $tax_value = ($invoice->tax != '') ? $invoice->tax : $core_settings->tax;
        $second_tax_value = ($invoice->second_tax != '') ? $invoice->second_tax : $core_settings->second_tax;
        $tax = sprintf('%01.2f', round(($sum / 100) * $tax_value, 2));
        $second_tax = sprintf('%01.2f', round(($sum / 100) * $second_tax_value, 2));
        $sum = sprintf('%01.2f', round($sum + $tax + $second_tax, 2));
        $invoice->sum = $sum;
        $invoice->save();
        return $invoice;
    }
}

class InvoiceHasPayment extends ActiveRecord\Model
{
    public static $belongs_to = [
    ['invoice'],
    ['user']
    ];
}

class InvoiceHasItem extends ActiveRecord\Model
{
    public static $belongs_to = [
    ['invoice'],
    ['item']
    ];
}

class Item extends ActiveRecord\Model
{
    public static $has_many = [
    ['invoice_has_items']
    ];
}
