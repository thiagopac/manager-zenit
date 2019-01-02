/* Norwegian locals for flatpickr */
var Flatpickr = Flatpickr || { l10ns: {} };
Flatpickr.l10ns.norwegian = {};

Flatpickr.l10ns.norwegian.weekdays = {
	shorthand: ['Søn', 'Man', 'Tir', 'Ons', 'Tor', 'Fre', 'Lør'],
	longhand: ['Søndag', 'Mandag', 'Tirsdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag']
};

Flatpickr.l10ns.norwegian.months = {
	shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des'],
	longhand: ['Januar', 'Februar', 'Mars', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Desember']
};

Flatpickr.l10ns.norwegian.ordinal = function () {
	return ".";
};
if (typeof module !== "undefined") {
	module.exports = Flatpickr.l10ns;
}