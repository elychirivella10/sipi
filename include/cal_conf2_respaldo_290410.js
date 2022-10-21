
//Define calendar(s): addCalendar ("Unique Calendar Name", "Window title", "Form element's name", Form name")
addCalendar("Calendar1", "Select Date", "fecha_solic", "forautor");
addCalendar("Calendar2", "Select Date", "fecha_firma", "forautor");
addCalendar("Calendar3", "Select Date", "vfechas", "forautor");
addCalendar("Calendar4", "Select Date", "fecha_solpf", "forfonog");
addCalendar("Calendar5", "Select Date", "fecha_solie", "forobfie");
addCalendar("Calendar6", "Select Date", "fecha_evento", "fordatev");
addCalendar("Calendar7", "Select Date", "fecha_solic", "formarcas2");
addCalendar("Calendar8", "Select Date", "fecha_prior", "formarcas2");

// default settings for English
// Uncomment desired lines and modify its values
// setFont("verdana", 9);
setWidth(90, 1, 15, 1);
// setColor("#cccccc", "#cccccc", "#ffffff", "#ffffff", "#333333", "#cccccc", "#333333");
// setFontColor("#333333", "#333333", "#333333", "#ffffff", "#333333");
setColor("#669EC4", "#1E5F99", "#ffffff", "#ffffff", "#333333", "#1E5F99", "#333333");
setFontColor("#333333", "#ffffff", "#333333", "#FFFF00", "#ffffff");
//setFormat("yyyy/mm/dd");
setFormat("dd/mm/yyyy");
// setSize(200, 200, -200, 16);
// setWeekDay(0);
setWeekDay(0);
// setMonthNames("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
// setDayNames("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
// setLinkNames("[Close]", "[Clear]");
setMonthNames("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
setDayNames("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
setLinkNames("[Cerrar]", "[Limpiar]");
