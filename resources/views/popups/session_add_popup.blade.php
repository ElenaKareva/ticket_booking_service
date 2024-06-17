<div class="popup" id="add_session_popup">
    <div class="popup__container">
        <div class="popup__content">
            <div class="popup__header">
                <h2 class="popup__title">
                    Добавление сеанса
                    <a class="popup__dismiss" href="#" ><img src="i/close.png" alt="Закрыть" id="close_session_popup"></a>
                </h2>
            </div>
            <div class="popup__wrapper">
                <form accept-charset="utf-8" name="addSession" action="{{ route('addSession') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <label class="conf-step__label conf-step__label-fullsize" for="title">
                        Название фильма
                        <input class="conf-step__input film_title" type="text" name="film" readonly>
                    </label>
                    <label class="conf-step__label conf-step__label-fullsize" for="name">
                        Выберите зал
                        <select class="conf-step__input" type="text" name="id" required>
                          @foreach($halls as $hall)
                            <option value="{{ $hall->id }}" selected>{{ $hall->name }}</option>
                          @endforeach
                        </select>
                    </label>
                    <label class="conf-step__label conf-step__label-fullsize" for="name">
                        Укажите дату
                        <input class="conf-step__input" type="date" name="date" id="date_limit" required></input>
                    </label>
                    <label class="conf-step__label conf-step__label-fullsize" for="name">
                        Укажите время
                        <input class="conf-step__input" type="time" value="00:00" name="time" required></input>
                    </label>
                    <div class="conf-step__buttons text-center">
                        <input type="submit" value="Добавить в сетку сеансов" class="conf-step__button conf-step__button-accent" name="addFilm">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>