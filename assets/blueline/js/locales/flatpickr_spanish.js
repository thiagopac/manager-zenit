/* Spanish locals for flatpickr */
var Flatpickr = Flatpickr || { l10ns: {} };
Flatpickr.l10ns.spanish = {};

Flatpickr.l10ns.spanish.weekdays = {
	shorthand: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
	longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']
};

Flatpickr.l10ns.spanish.months = {
	shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
	longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
};

Flatpickr.l10ns.spanish.ordinal = function () {
	return "º";
};

Flatpickr.l10ns.spanish.firstDayOfWeek = 1;
if (typeof module !== "undefined") {
	module.exports = Flatpickr.l10ns;
}