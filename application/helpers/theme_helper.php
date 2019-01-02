<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

    function get_theme_colors($settings)
    {
        $instance = &get_instance();
        $return = '';
        if ($settings->custom_colors == 1) {
            function HEXtoRGB($RGB)
            {
                $R = hexdec(substr($RGB, 1, 2));
                $G = hexdec(substr($RGB, 3, 2));
                $B = hexdec(substr($RGB, 5, 2));
                return $R . ',' . $G . ',' . $B;
            }
            if ($settings->primary_color[0] == '#') {
                $primary_hover_color = 'rgba(' . HEXtoRGB($settings->primary_color) . ',0.8)';
            } else {
                $primary_hover_color = $settings->primary_color;
            }
            $return .= '<style>';

            $return .= "body{
                        background: $settings->body_background;
                        } ";
            $return .= ".btn-primary, .progress-bar, .popover-title, .dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover, .fc-state-default, .chosen-container-multi .chosen-choices li.search-choice{
                        background: $settings->primary_color;
                        }";
            $return .= ".btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open>.dropdown-toggle.btn-primary{
                        background: $primary_hover_color;
                        }";
            $return .= '.nav-sidebar > li > a:hover{
                            background: rgba(40, 169, 241, 0.11);
                            transition: background 0.2s ease;
                        }';
            $return .= ".table-head, #main .action-bar, #message .header, .form-header, .notification-center__header a.active{
                        box-shadow: 0 -2px 0 0 $settings->primary_color inset;
                        }";
            $return .= ".form-header{
                        color: $settings->primary_color;
                        }";
            $return .= ".nav.nav-sidebar>li.active>a, .modal-header, .ui-slider-range, .ui-slider-handle:before, .list-group-item.active:hover, .list-group-item.active:focus,.icon-frame{
                        background-image: none;
                        background: $settings->primary_color;
                        }";
            $return .= ".list-group-item.active, .list-group-item.active:hover, .list-group-item.active .list-group-item-icon{
                        background: none;
                        background-image: none;
                        color: $settings->primary_color;
                        }";
            $return .= ".sidebar-bg{
                        background: $settings->menu_background;
                        } ";
            $return .= ".user_online__indicator{
                        border-color: $settings->menu_background;
                        } ";

            $return .= ".sidebar a, .sidebar h4, .nav>li>a, .nav-sidebar span.menu-icon i{
                        color: $settings->menu_color;
                        } ";
            $return .= ".mainnavbar{
                        background: $settings->top_bar_background;
                        } ";
            $return .= ".topbar__icon_alert{
                        border-color: $settings->top_bar_background;
                        } ";
            $return .= ".mainnavbar{
                        color: $settings->top_bar_color;
                        } ";
            if ($settings->login_style == 'center') {
                $return .= '.form-signin{
                        margin: 5% auto;
                        min-height: 400px;
                        padding: 60px 60px;
                        max-width: 450px;
                        } ';
            }

            $return .= '</style>';
        }

        return $return;
    }
