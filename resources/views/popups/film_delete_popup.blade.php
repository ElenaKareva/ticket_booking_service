<div class="popup" id="delete_film_popup">
    <div class="popup__container">
        <div class="popup__content">
            <div class="popup__header">
                <h2 class="popup__title">
                    Удаление фильма
                    <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть" id="close_filmDelete_popup"></a>
                </h2>
            </div>
            <div class="popup__wrapper">

                <p class="conf-step__paragraph">Нажмите на фильм, чтобы удалить</p>
                <div class="conf-step__movies">
                    @foreach($films as $film)
                    <div class="conf-step__movie">
                        <img class="conf-step__movie-poster" alt="poster" src="{{ asset('storage/'.$film->image) }}">
                        <h3 class="conf-step__movie-title">{{ $film->title }}</h3>
                        <p class="conf-step__movie-duration">{{ $film->duration }} минут</p>
                        <a href="{{ route('deleteFilm', $film->id) }}"><button class="conf-step__button conf-step__button-trash"></button></a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>