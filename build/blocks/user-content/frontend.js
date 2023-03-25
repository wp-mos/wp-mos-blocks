/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************************!*\
  !*** ./src/blocks/user-content/frontend.js ***!
  \*********************************************/
document.addEventListener("DOMContentLoaded", () => {
  const tabs = document.querySelectorAll(".wp-block-mos-blocks-auth-user-content-sidebar-navigation>li>a");
  const contulMeu = document.querySelector("#contul-meu");
  const schimbaParola = document.querySelector("#schimba-parola");
  const comenzileMele = document.querySelector("#comenzile-mele");
  tabs.forEach((currentTab, index) => {
    if (index === 0) {
      currentTab.classList.add("is-active");
      schimbaParola.style.display = "none";
      comenzileMele.style.display = "none";
    }
  });
  tabs.forEach(tab => {
    tab.addEventListener("click", event => {
      event.preventDefault();
      tabs.forEach(currentTab => {
        currentTab.classList.remove("is-active");
      });
      event.currentTarget.classList.add("is-active");
      const activeTab = event.currentTarget.getAttribute("href");
      if (activeTab === "#contul-meu") {
        contulMeu.style.display = "flex";
        schimbaParola.style.display = "none";
        comenzileMele.style.display = "none";
      } else if (activeTab === "#schimba-parola") {
        contulMeu.style.display = "none";
        schimbaParola.style.display = "flex";
        comenzileMele.style.display = "none";
      } else {
        contulMeu.style.display = "none";
        schimbaParola.style.display = "none";
        comenzileMele.style.display = "flex";
      }
    });
  });
});
/******/ })()
;
//# sourceMappingURL=frontend.js.map