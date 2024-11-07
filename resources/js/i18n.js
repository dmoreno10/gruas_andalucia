import { createI18n } from 'vue-i18n';

// Define los mensajes traducidos
const messages = {
    en: {
        message: {
            hello: 'Hello!',
            welcome: 'Welcome to our application!'
        }
    },
    es: {
        message: {
            hello: '¡Hola!',
            welcome: '¡Bienvenido a nuestra aplicación!'
        }
    }
    // Agrega más idiomas según sea necesario
};

// Crea la instancia de i18n
const i18n = createI18n({
    locale: 'es', // Establece el idioma por defecto
    fallbackLocale: 'en', // Idioma de respaldo
    messages, // Mensajes traducidos
});

export default i18n;
