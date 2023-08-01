/**
 * Controlling the display of the sidebar and highlighting the active sidebar item
 * */
document.addEventListener("DOMContentLoaded", function (event) {
    const showNavbar = (pageId, sidebarId, headerId, toggleId) => {
        const page = document.getElementById(pageId),
            sidebar = document.getElementById(sidebarId),
            header = document.getElementById(headerId),
            toggle = document.getElementById(toggleId);
        if (toggle && sidebar && page && header) {
            toggle.addEventListener("click", () => {
                sidebar.classList.toggle("sidebar_displayed");
                toggle.classList.toggle("bx-x");
                page.classList.toggle("page_menu-displayed");
                header.classList.toggle("header_menu-displayed");
            });
        }
    };

    showNavbar("page", "sidebar", "header", "header__toggle");

    const sidebarLinks = document.querySelectorAll(".sidebar__link");
    function highlightLink() {
        if (sidebarLinks) {
            sidebarLinks.forEach((l) => l.classList.remove("sidebar__link_active"));
            this.classList.add("sidebar__link_active");
        }
    }
    sidebarLinks.forEach((link) => link.addEventListener("click", highlightLink));
});
