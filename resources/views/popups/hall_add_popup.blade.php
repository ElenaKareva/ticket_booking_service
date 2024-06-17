<div class="popup" id="add_hall_popup">
    <div class="popup__container">
        <div class="popup__content">
            <div class="popup__header">
                <h2 class="popup__title">
                    Добавление зала
                    <a class="popup__dismiss" href="#" ><img src="i/close.png" alt="Закрыть" id="close_hall_popup"></a>
                </h2>
            </div>
            <div class="popup__wrapper">
                <form accept-charset="utf-8" name="hallAddForm" action="{{ route('addHall') }}" method="post">
                    @csrf
                    <label class="conf-step__label conf-step__label-fullsize" for="name">
                        Введите нзвание зала
                        <input class="conf-step__input" type="text" placeholder="Например, Зал № 1" name="name" id="hallNameAdd" required>
                    </label>
                    <div class="conf-step__buttons text-center">
                        <input type="submit" value="Добавить зал" class="conf-step__button conf-step__button-accent" name="addHall">
                        <button class="conf-step__button conf-step__button-regular">Отменить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>