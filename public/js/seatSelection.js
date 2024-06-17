const chairsHall = Array.from(document.getElementsByName('chairs-hall'));
const sizeHall = Array.from(document.querySelectorAll('.conf-step__hall'));
let valueRows = document.getElementById('value_rows');
let valueSeats = document.getElementById('value_seats');
const hallWrapper = Array.from(document.querySelectorAll('.conf-step__hall-wrapper'));
function changeSeats() {
  let seats = Array.from(document.querySelectorAll('.conf-step__row .conf-step__chair'));
  seats.forEach(seat => seat.addEventListener('click', function () {
    if (seat.classList.contains('conf-step__chair_standart')) {
     seat.classList.toggle('conf-step__chair_standart');
     seat.classList.toggle('conf-step__chair_vip');
 } else if (seat.classList.contains('conf-step__chair_vip')) {
     seat.classList.toggle('conf-step__chair_vip');
     seat.classList.toggle('conf-step__chair_disabled');
 } else if (seat.classList.contains('conf-step__chair_disabled')) {
     seat.classList.toggle('conf-step__chair_disabled');
     seat.classList.toggle('conf-step__chair_standart');
    }
}));
};
changeSeats();
for (let i = 0; i < chairsHall.length; i++) {
  chairsHall[i].addEventListener('click', function () {
    sizeHall.forEach(size => {
      size.style.display = 'none';
    });
    sizeHall[i].style.display = 'block';
    let rows = [...sizeHall[i].querySelectorAll('.conf-step__row')];
    valueRows.value = rows.length;
    if (rows.length > 0) {
      let seats = [...rows[0].querySelectorAll('.conf-step__chair')];
      valueSeats.value = seats.length;
    } else {valueSeats.value = 0};
    valueRows.oninput = function () {
      if (valueRows.value > 20) {valueRows.value = 20};
      if (valueRows.value < 1) {valueRows.value = 1};
      hallWrapper[i].innerHTML = '';
      for (let q = 0; q < +(valueRows.value); q++) {
        hallWrapper[i].insertAdjacentHTML('afterBegin', `<div class="conf-step__row"></div>`);
      }
      let stepRow = [...hallWrapper[i].querySelectorAll('.conf-step__row')];
      stepRow.forEach(seat => {
        for (let w = 0; w < +(valueSeats.value); w++) {
          seat.insertAdjacentHTML('afterBegin',`<span class="conf-step__chair conf-step__chair_standart"></span>`)
        }
      })
      changeSeats();
    }
    valueSeats.oninput = function () {
      if (valueSeats.value > 20) {valueSeats.value = 20};
      if (valueSeats.value < 3) {valueSeats.value = 3};
      hallWrapper[i].innerHTML = '';
      for (let q = 0; q < +(valueRows.value); q++) {
        hallWrapper[i].insertAdjacentHTML('afterBegin', `<div class="conf-step__row"></div>`);
      }
      let stepRow = [...hallWrapper[i].querySelectorAll('.conf-step__row')];
      stepRow.forEach(seat => {
        for (let w = 0; w < +(valueSeats.value); w++) {
          seat.insertAdjacentHTML('afterBegin',`<span class="conf-step__chair conf-step__chair_standart"></span>`)
        }
      })
      changeSeats();
    }
  })
}
$(document).ready(function () {
  $('#save_new_size').click(function () {
    let rows = +(valueRows.value);
    let seats = +(valueSeats.value);
    sizeHall.forEach(size => {
      if (size.style.display === "block") {
        let config = size.children[0].innerHTML;
        chairsHall.forEach(chairs => {
          if (chairs.checked) {
            let id = chairs.value;
            $.ajax({
              url: '/config/update',
              type: 'POST',
              data: {
                id: id,
                rows: rows,
                seats: seats,
                config: config
              },
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              success: function (data) {
                alert (data.success);
                window.location.href = 'admin';
              },
              error: function () {
              }
            })
          }
        })
      }
    })
  });
})