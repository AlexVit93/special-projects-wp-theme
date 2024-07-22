document.addEventListener("DOMContentLoaded", () => {
  const myModal = document.getElementById("myModal");
  const openModalButtons = document.querySelectorAll(".open-modal-button");
  const closeModalButton = document.querySelector(".modal-ok-button");

  openModalButtons.forEach((button) => {
    button.addEventListener("click", () => {
      myModal.style.display = "flex";
    });
  });

  closeModalButton.addEventListener("click", () => {
    myModal.style.display = "none";
  });

  window.addEventListener("click", (event) => {
    if (event.target === myModal) {
      myModal.style.display = "none";
    }
  });
});
