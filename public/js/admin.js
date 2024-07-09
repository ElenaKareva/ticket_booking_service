// открываем popup добавления зала
const createHall = document.getElementById('create_hall');
const addHallPopup = document.getElementById('add_hall_popup');
createHall.addEventListener('click', function () {
  addHallPopup.classList.toggle('active');
})

// закрываем popup добавления зала
const closeHallPopup = document.getElementById('close_hall_popup');
closeHallPopup.addEventListener('click', function (e) {
  e.preventDefault();
  addHallPopup.classList.toggle('active');
});

// регулировка цен зала 
const pricesHall = Array.from(document.getElementsByName('prices-hall'));
let standartPrice = document.getElementById('standart_price');
let vipPrice = document.getElementById('vip_price');
pricesHall.forEach(el => el.addEventListener('click', function () {
  standartPrice.value = '';
  vipPrice.value = '';
  $.ajax({
    url: 'admin/price',
    type: 'GET',
    data: {
      id: el.value
    },
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (data) {
      standartPrice.value = data[0].standart_price;
      vipPrice.value = data[0].vip_price;
    }
  });
  $('#save_new_price').click(function () {
    if (el.checked) {
      $.ajax({
        url: 'admin/price/update',
        type: 'POST',
        data: {
          id: el.value,
          standart_price: standartPrice.value,
          vip_price: vipPrice.value
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          alert('Цены успешно обновлены')
        },
        error: function () {
          alert('Ошибка! Поле "Цена" должно быть заполнено и содержать цифры')
        }
      })
    }
  })
}));

// открываем popup добавления фильма
const createFilm = document.getElementById('create_film');
const addFilmPopup = document.getElementById('add_film_popup');
createFilm.addEventListener('click', function () {
  addFilmPopup.classList.toggle('active');
})

// закрываем popup добавления фильма
const closeFilmPopup = document.getElementById('close_film_popup');
closeFilmPopup.addEventListener('click', function (e) {
  e.preventDefault();
  addFilmPopup.classList.toggle('active');
});

//открываем popup удаление фильма
const deleteFilm = document.getElementById('delete_film');
const deleteFilmPopup = document.getElementById('delete_film_popup');
deleteFilm.addEventListener('click', function () {
  deleteFilmPopup.classList.toggle('active');
})

// закрываем popup удаления фильма
const closeFilmDeletePopup = document.getElementById('close_filmDelete_popup');
closeFilmDeletePopup.addEventListener('click', function (e) {
  e.preventDefault();
  deleteFilmPopup.classList.toggle('active');
});

//отображение списка фильмов


let addSessions = Array.from(document.querySelectorAll('.conf-step__movie'));
const addSessionPopup = document.getElementById('add_session_popup');

// открываем popup добавления сеанса
addSessions.forEach(session => {
  session.addEventListener('click', function () {
    let titleFilm = session.querySelector('.conf-step__movie-title');
    let film = document.querySelector('.film_title');
    film.value = titleFilm.textContent;
    addSessionPopup.classList.toggle('active');
  })
});

// закрываем popup добавления сеанса
const closeSessionPopup = document.getElementById('close_session_popup');
closeSessionPopup.addEventListener('click', function (e) {
  e.preventDefault();
  addSessionPopup.classList.toggle('active');
});

// ограничение выбора даты сеанса сегодняшним днем
document.getElementById('date_limit').min = new Date().toISOString().split("T")[0];


//Checkbox
var checkboxes = document.querySelectorAll('.checkbox-wrapper input[type="checkbox');
checkboxes.forEach(function (checkbox) {
  checkbox.addEventListener('change', function () {
    if (this.checked) {
      this.parentElement.classList.add('checked');
    } else {
      this.parentElement.classList.remove('checked');
    }
  });
})
