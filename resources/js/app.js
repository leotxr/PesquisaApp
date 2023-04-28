import './bootstrap';
import 'tw-elements';
import 'flowbite';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

/*
window.addEventListener("contextmenu", ev => {
    ev.preventDefault();
    return false;
});


window.addEventListener("keydown", ev => {
    switch(true){
        //previne f12
        case ev.keyboard.event.keyCode === 123:

        // prefine CTRL + SHIFT + ESPACO
        case ev.ctrlKey && ev.shiftKey:

        case ev.ctrlKey && ev.keyCode == 85:
            ev.preventDefault();
            return false;

    }
});

*/