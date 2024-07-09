<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ИдёмВКино</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/adminstyles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
</head>

@include('popups.hall_add_popup')
@include('popups.film_add_popup')
@include('popups.session_add_popup')
@include('popups.film_delete_popup')


<body>
  <header class="page-header">
    <h1 class="page-header__title">
      <a class="logout_admin" href="{{ route('logout') }}"
          onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">Идём<span>в</span>кино</a>
    </h1>
    <span class="page-header__subtitle">Администраторррская</span>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
      @csrf
    </form>
  </header>

  <main class="conf-steps">
    @include('messages')

    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Управление залами</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Доступные залы:</p>
        <ul class="conf-step__list">
          @foreach($halls as $hall)
            <li>{{ $hall->name }}
              <a href="{{ route('deleteHall', $hall->id) }}"><button class="conf-step__button conf-step__button-trash"></button></a>
            </li>
          @endforeach
        </ul>
        <button class="conf-step__button conf-step__button-accent" id="create_hall">Создать зал</button>
      </div>
    </section>
    
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Конфигурация залов</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step__selectors-box">
          @foreach($halls as $hall)
            <li><input type="radio" class="conf-step__radio" name="chairs-hall" value="{{ $hall->id }}"><span class="conf-step__selector">{{ $hall->name }}</span></li>
          @endforeach
        </ul>
        <p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
        <div class="conf-step__legend">
          <label class="conf-step__label">Рядов, шт<input type="number" class="conf-step__input" placeholder="0" id='value_rows' ></label>
          <span class="multiplier">x</span>
          <label class="conf-step__label">Мест, шт<input type="number" class="conf-step__input" placeholder="0" id='value_seats' ></label>
        </div>
        <p class="conf-step__paragraph">Теперь вы можете указать типы кресел на схеме зала:</p>
        <div class="conf-step__legend">
          <span class="conf-step__chair conf-step__chair_standart"></span> — обычные кресла
          <span class="conf-step__chair conf-step__chair_vip"></span> — VIP кресла
          <span class="conf-step__chair conf-step__chair_disabled"></span> — заблокированные (нет кресла)
          <p class="conf-step__hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
        </div>  
        
        @foreach($halls as $hall)
          <div class="conf-step__hall">
            <div class="conf-step__hall-wrapper">
              {!! html_entity_decode($hall->config) !!}
            </div>  
          </div>
        @endforeach
        
        <fieldset class="conf-step__buttons text-center">
          <!-- <button class="conf-step__button conf-step__button-regular">Отмена</button> -->
          <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent" id='save_new_size'>
        </fieldset>                 
      </div>
    </section>
    
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Конфигурация цен</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step__selectors-box">
          @foreach($halls as $hall)
            <li><input type="radio" class="conf-step__radio" name="prices-hall" value="{{ $hall->id }}"><span class="conf-step__selector">{{ $hall->name }}</span>
            </li>
          @endforeach
          </ul>
          
        <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
          <div class="conf-step__legend">
            <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input" placeholder="200" id="standart_price" ></label>
            за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
          </div>  
          <div class="conf-step__legend">
            <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input" placeholder="400" id="vip_price"></label>
            за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
          </div>  
        
        <fieldset class="conf-step__buttons text-center">
          <!-- <button class="conf-step__button conf-step__button-regular">Отмена</button> -->
          <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent" id='save_new_price'>
        </fieldset>  
      </div>
    </section>
    
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Сетка сеансов</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">
          <button class="conf-step__button conf-step__button-accent" id="create_film">Добавить фильм</button>
        </p>
        <p class="conf-step__paragraph">
          <button class="conf-step__button conf-step__button-accent" id="delete_film">Удалить фильм</button>
        </p>
        <p class="conf-step__paragraph">Нажмите на фильм для добавления в сетку сеансов:</p>
        <div class="conf-step__movies">
          @foreach($films as $film)
          <div class="conf-step__movie">
            <img class="conf-step__movie-poster" alt="poster" src="{{ asset('storage/'.$film->image) }}">
            <h3 class="conf-step__movie-title">{{ $film->title }}</h3>
            <p class="conf-step__movie-duration">{{ $film->duration }} минут</p>
            <!--<a href="{{ route('deleteFilm', $film->id) }}"><button class="conf-step__button conf-step__button-trash"></button></a>-->
          </div>
          @endforeach
        </div>
        
        <div class="conf-step__seances">
          @foreach($sessions->groupby('date') as $date => $value)
            <h3 class="conf-step__seances-title_hall">{{ date('d.m.Y', strtotime($date)) }}</h3>
            @foreach($value->groupby('name_hall') as $name_hall => $el)
            <div class="conf-step__seances-hall">
              <h3 class="conf-step__seances-title">{{ $name_hall }}</h3>
              <div class="conf-step__seances-timeline">
                @for($i = 0; $i < $el->count(); $i++)
                <div class="conf-step__seances-movie" style="width: {{ $el[$i]->duration }}px; background-color: rgb(133, 255, 137); left: {{ $el[$i]->minute_start }}px;">
                  <p class="conf-step__seances-movie-title">{{ $el[$i]->title_film }}</p>
                  <a href="{{ route('deleteSession', $el[$i]->id) }}"><button class="conf-step__button conf-step__button-trash" style="left: calc({{ $el[$i]->duration }}px - 30px);"></button></a>
                  <p class="conf-step__seances-movie-start">{{ $el[$i]->session_start }}</p>
                </div>
                @endfor             
              </div>
            </div>
            @endforeach
          @endforeach
        </div>
      </div>
    </section>
    
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Открыть продажи</h2>
      </header>
      <div class="conf-step__wrapper text-center">
          <form accept-charset="utf-8" name="startSale" action="{{ route('startSale') }}" method="post">
          <p class="conf-step__paragraph">Выберете залы для продажи билетов:</p>
          
              @csrf
              <div class="checkbox-wrapper">
                @foreach($halls as $hall)
                <!--<span class="checkbox-btn"> -->
                <label>
                <span class="checkbox-btn">
                    <input type="hidden" name="{{ $hall->id }}" value="off">
                    <input type="checkbox"  name="{{ $hall->id }}" {{ $hall->active_hall === 'on' ? 'checked' : '' }}>
                    <span class="conf-step__seances-title">{{ $hall->name }}</span>
                    </span>
                    </label>
                    <!--</span>-->
                @endforeach
                </div>
                  <div class="conf-step__wrapper text-center">
                        <p class="conf-step__paragraph">Всё готово, теперь можно:</p>
                        <fieldset form="updateSales" class="conf-step__buttons text-center">
                        <button type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent" id="open_sales">
                            Обновить продажи
                        </button>
                    </fieldset>
                    </div>

            </form>

        </section>
    </main>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="js/accordeon.js"></script>
  <script src="js/seatSelection.js"></script>
  <script src="js/admin.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  
</body>
</html>
