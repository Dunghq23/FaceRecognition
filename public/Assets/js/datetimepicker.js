$(document).ready(function() {
    // Generate calendar
    const dateInput = $('#dateInput');
    const calendar = $('.date-picker-calendar table');
    const date = new Date();
    let selectedDate = date;
    generateCalendar(date.getFullYear(), date.getMonth());

    // Generate time slots
    const timeInput = $('#timeInput');
    const timeClock = $('.time-picker-clock');
    generateTimeSlots();

    // Show/hide date picker
    $('.date-picker').on('click', function(e) {
      e.stopPropagation();
      $('.date-picker-calendar').toggle();
    });

    // Show/hide time picker
    $('.time-picker').on('click', function(e) {
      e.stopPropagation();
      $('.time-picker-clock').toggle();
    });

    // Hide on click outside
    $(document).on('click', function() {
      $('.date-picker-calendar').hide();
      $('.time-picker-clock').hide();
    });

    // Prevent hiding when clicking inside the picker
    $('.date-picker-calendar, .time-picker-clock').on('click', function(e) {
      e.stopPropagation();
    });

    // Date selection
    calendar.on('click', 'td', function() {
      const day = $(this).text();
      selectedDate.setDate(day);
      dateInput.val(formatDate(selectedDate));
      calendar.find('td').removeClass('selected');
      $(this).addClass('selected');
      $('.date-picker-calendar').hide();
    });

    // Time selection
    timeClock.on('click', 'td', function() {
      const time = $(this).text();
      timeInput.val(time);
      timeClock.find('td').removeClass('selected');
      $(this).addClass('selected');
      $('.time-picker-clock').hide();
    });

    // Generate calendar for the selected month
    function generateCalendar(year, month) {
      calendar.empty();
      const firstDay = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();
      let date = 1;
      for (let i = 0; i < 6; i++) {
        const row = $('<tr>');
        for (let j = 0; j < 7; j++) {
          if (i === 0 && j < firstDay) {
            row.append('<td></td>');
          } else if (date > daysInMonth) {
            break;
          } else {
            const cell = $('<td>').text(date);
            if (date === selectedDate.getDate() && year === selectedDate.getFullYear() && month === selectedDate.getMonth()) {
              cell.addClass('selected');
            }
            row.append(cell);
            date++;
          }
        }
        calendar.append(row);
      }
    }

    // Generate time slots for 12 hours
    function generateTimeSlots() {
      const times = [];
      for (let i = 0; i < 24; i++) {
        const hour = i % 12 || 12;
        const period = i < 12 ? 'AM' : 'PM';
        times.push(`${hour}:00 ${period}`);
        times.push(`${hour}:30 ${period}`);
      }
      timeClock.empty();
      times.forEach(time => {
        const row = $('<tr><td>').text(time);
        timeClock.append(row);
      });
    }

    // Format date as MM/DD/YYYY
    function formatDate(date) {
      const month = date.getMonth() + 1;
      const day = date.getDate();
      const year = date.getFullYear();
      return `${month.toString().padStart(2, '0')}/${day.toString().padStart(2, '0')}/${year}`;
    }
  });