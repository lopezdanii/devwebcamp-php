import Swiper from 'swiper';
import { Mousewheel } from 'swiper/modules';
import { Navigation } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';

document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('.slider')) {
      Swiper.use([Navigation, Mousewheel]);
  
      const opciones = {
        slidesPerView: 1,
        spaceBetween: 15,
        freeMode: true,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        mousewheel: {
          forceToAxis: true,
          invert: false,
          sensitivity: 1,
        },
        breakpoints: {
          768: {
            slidesPerView: 2,
          },
          1024: {
            slidesPerView: 3,
          },
          1200: {
            slidesPerView: 4,
          },
        },
      };
  
      new Swiper('.slider', opciones);
    }
  });
  