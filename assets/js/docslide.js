document.addEventListener("DOMContentLoaded", function () {
  let swiper = new Swiper(".doctors__slider", {
    slidesPerView: 2,
    spaceBetween: 30,
    loop: true,
    slidesPerGroup: 1,
    navigation: {
      nextEl: ".doctors__next",
      prevEl: ".doctors__prev",
    },
    breakpoints: {
      1300: {
        slidesPerView: 4,
        spaceBetween: 20,
      },
    },
    on: {
      slideChange: function () {
        document.querySelectorAll(".doctors__photo").forEach(function (photo) {
          photo.classList.remove("active-doctor");
        });

        let activePhoto =
          this.slides[this.activeIndex].querySelector(".doctors__photo");
        if (activePhoto) {
          activePhoto.classList.add("active-doctor");
        }
        updateDoctorInfo(this.slides[this.activeIndex]);
      },
    },
  });

  function updateDoctorInfo(slide) {
    let photoContainer = document.querySelector(
      ".doctors__info-photo-container"
    );
    let textContainer = document.querySelector(".doctors__info-text-container");

    let name = slide.dataset.name;
    let specialty = slide.dataset.specialty;
    let experience = slide.dataset.experience;
    let description = slide.dataset.description;
    let education = slide.dataset.education;
    let photoSrc = slide.dataset.photo;

    photoContainer.innerHTML = `<img class="doctors__info-photo" src="${photoSrc}" alt="${name}">`;
    textContainer.innerHTML = `
      <h2 class="doctors__info-name">${name}</h2>
      <h2 class="doctors__info-specialty">${specialty}</h2>
      <h3 class="doctors__info-experience">${experience}</h3>
      <p class="doctors__info-description">${description}</p>
      <p class="doctors__info-education">${education}</p>
      <button class="doctors__info-appointment button" data-doctor-name="${name}">Запись к врачу</button>
    `;
  }

  updateDoctorInfo(swiper.slides[swiper.activeIndex]);
});
