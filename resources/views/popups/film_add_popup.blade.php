<div class="popup" id="add_film_popup">
    <div class="popup__container">
        <div class="popup__content">
            <div class="popup__header">
                <h2 class="popup__title">
                    Добавление фильма
                    <a class="popup__dismiss" href="#" ><img src="i/close.png" alt="Закрыть" id="close_film_popup"></a>
                </h2>
            </div>
            <div class="popup__wrapper">
                <form accept-charset="utf-8" name="filmAddForm" action="{{ route('addFilm') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <label class="conf-step__label conf-step__label-fullsize" for="name">
                        Название фильма
                        <input class="conf-step__input" type="text" placeholder="Например: &laquo;Взрыв из прошлого&raquo;" name="title" required>
                    </label>
                    <label class="conf-step__label conf-step__label-fullsize" for="name">
                        Продолжительность фильма
                        <input class="conf-step__input" type="text" placeholder="Например: &laquo;123&raquo;" name="duration" required>
                    </label>
                    <label class="conf-step__label conf-step__label-fullsize" for="name">
                        Описание фильма
                        <textarea class="conf-step__input" type="text" placeholder="Например: &laquo;Приняв авиакатастрофу за ядерный удар, талантливый изобретатель Кэлвин Уэббер вместе с беременной женой Хелен укрывается в специальном подземном бункере...&raquo;" name="description" required></textarea>
                    </label>
                    <label class="conf-step__label conf-step__label-fullsize" for="name">
                        Страна
                        <input class="conf-step__input" type="text" placeholder="Например: &laquo;США&raquo;" name="country" required>
                    </label>
                    <label class="conf-step__label conf-step__label-fullsize" for="name">
                        Постер (формат jpg, jpeg, png)
                        <input class="conf-step__input" type="file" placeholder="" name="image" required>
                    </label>
                    <div class="conf-step__buttons text-center">
                        <input type="submit" value="Добавить фильм" class="conf-step__button conf-step__button-accent" name="addFilm">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>