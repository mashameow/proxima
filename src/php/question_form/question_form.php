<!-- form.php -->
<section class="questions">
    <div class="questions__container container">
        <h2 class="questions__title SoyuzGrotesk section-title">
            Появились вопросы?
        </h2>
        <p class="questions__text">Мы ответим в течении часа</p>
        <form action="submit.php" method="POST">
            <div class="questions__info">
                <div class="questions__info-inpus">
                    <input
                        type="text"
                        placeholder="Имя"
                        class="questions__info-inpus-input input"
                        name="name" 
                        required
                    />
                    <input
                        type="email"
                        placeholder="Email"
                        class="questions__info-inpus-input input"
                        name="email" 
                        required
                    />
                    <input
                        type="tel"
                        placeholder="Телефон"
                        class="questions__info-inpus-input input"
                        name="phone" 
                        required
                    />
                </div>
                <textarea
                    name="question"
                    id="questions__info-textarea"
                    placeholder="Что вас интересует?"
                    class="questions__info-textarea input"
                    required
                ></textarea>
            </div>
            <div class="questions__btn-container">
                <button type="submit" class="button pink hero__info-button questions__btn">
                    задать вопрос
                </button>
            </div>
        </form>
    </div>
</section>
