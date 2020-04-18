import Vue from 'vue'
import VueI18n from 'vue-i18n'

Vue.use(VueI18n)

const messages = {
    'en': {
        Bible: "Holy Bible",
        Registration: "Registration",
        Login: "Login",
        Logout: "Logout",
        Hello: "Hello",
        Chapter: "Chapter",
        ToIndex: "Table of Contents",
        MarkChapterAsRead: "Mark Chapter as read",
        YouNeed: "You need",
        authorize: "login",
        toMarkChapterAsRead: "to mark this chapter as read",
        ChapterAlreadyRead: "Chapter alread read",
        PressAgainToMarkAsRead: "Press again to mark this Chapter unread",
        MarkAsRead: "Mark this Chapter as read",
        AfterReadPressButton: "Don't forget to press this button after reading the chapter",
        Previous: "Previous",
        Next: "Next",
        Index: "Index",
        Settings: "Settings",
        Language: "Language",
        Theme: "Theme",
        Light: "Light",
        Dark: "Dark",
        Close: "Close",
        Password: "Password",
        Enter: "Login",
        Name: "Name",
        Email: "Email",
        PasswordOneMore: "Repeat password",
        RegisterUser: "User registration",
        NotReaded: "Not read",
        Readed: "Read",
        ReadedChapters: "Chapters read",
        UsersReadedChapters: "Users read chapters",
        ProgressForMonth: "Progress for the past month",
    },
    'ua': {
        Bible: "Біблія",
        Registration: "Реєстрація",
        Login: "Логін",
        Logout: "Вийти",
        Hello: "Привіт",
        Chapter: "Розділ",
        ToIndex: "Зміст",
        MarkChapterAsRead: "Відмітити главу прочитаною",
        YouNeed: "Необхідно",
        authorize: "авторизуватися",
        toMarkChapterAsRead: "щоб відмітити главу як прочитану",
        ChapterAlreadyRead: "Глава вже прочитана",
        PressAgainToMarkAsRead: "Натисніть ще раз щоб відмітити главу як прочитану",
        MarkAsRead: "Відмітити главу прочитаною",
        AfterReadPressButton: "Після прочитання глави не забудьте натиснути цю кнопку",
        Previous: "Попередня",
        Next: "Наступна",
        Index: "Зміст",
        Settings: "Налаштування",
        Language: "Мова",
        Theme: "Тема",
        Light: "Світла",
        Dark: "Темна",
        Close: "Закрити",
        Password: "Пароль",
        Enter: "Вхід",
        Name: "Iм'я",
        Email: "Email",
        PasswordOneMore: "Пароль ще раз",
        RegisterUser: "Реєстрація користувача",
        NotReaded: "Не прочитано",
        Readed: "Прочитано",
        ReadedChapters: "Прочитано глав",
        UsersReadedChapters: "Наші користувачі прочитали глав",
        ProgressForMonth: "Прогрес читання за місяць",
    },
    'ru': {
        Bible: "Библия",
        Registration: "Регистрация",
        Login: "Логин",
        Logout: "Выйти",
        Hello: "Привет",
        Chapter: "Глава",
        ToIndex: "К оглавлению",
        MarkChapterAsRead: "Отметить главу прочитанной",
        YouNeed: "Необходимо",
        authorize: "авторизироваться",
        toMarkChapterAsRead: "чтоб отметить главу как прочитанную",
        ChapterAlreadyRead: "Глава уже прочитана",
        PressAgainToMarkAsRead: "Нажмите еще раз чтобы отметить главу как не прочитанную",
        MarkAsRead: "Отметить главу прочитанной",
        AfterReadPressButton: "После прочтения главы не забудьте нажать эту кнопку",
        Previous: "Предыдущая",
        Next: "Следующая",
        Index: "Оглавление",
        Settings: "Настройки",
        Language: "Язык",
        Theme: "Тема",
        Light: "Светлая",
        Dark: "Темная",
        Close: "Закрыть",
        Password: "Пароль",
        Enter: "Вход",
        Name: "Имя",
        Email: "Email",
        PasswordOneMore: "Пароль еще раз",
        RegisterUser: "Регистрация пользователя",
        NotReaded: "Не прочитано",
        Readed: "Прочитано",
        ReadedChapters: "Прочитано глав",
        UsersReadedChapters: "Наши пользователи прочитали глав",
        ProgressForMonth: "Прогресс чтения за месяц",
    }
};

const i18n = new VueI18n({
    locale: localStorage.lang || 'ru',
    fallbackLocale: 'en',
    messages,
});

export default i18n;