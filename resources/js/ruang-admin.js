"use strict"; // Start of use strict

// Toggle the side navigation
document.querySelectorAll("#sidebarToggle, #sidebarToggleTop").forEach(function (el) {
  el.addEventListener("click", function () {
    document.body.classList.toggle("sidebar-toggled");
    let sidebar = document.querySelector(".sidebar");
    sidebar.classList.toggle("toggled");

    if (sidebar.classList.contains("toggled")) {
      document.querySelectorAll(".sidebar .collapse").forEach(function (collapseEl) {
        let bsCollapse = bootstrap.Collapse.getInstance(collapseEl);
        if (bsCollapse) {
          bsCollapse.hide();
        } else {
          new bootstrap.Collapse(collapseEl, { toggle: false }).hide();
        }
      });
    }
  });
});

// Close any open menu accordions when window is resized below 768px
window.addEventListener("resize", function () {
  if (window.innerWidth < 768) {
    document.querySelectorAll(".sidebar .collapse").forEach(function (collapseEl) {
      let bsCollapse = bootstrap.Collapse.getInstance(collapseEl);
      if (bsCollapse) {
        bsCollapse.hide();
      } else {
        new bootstrap.Collapse(collapseEl, { toggle: false }).hide();
      }
    });
  }
});

// Prevent the content wrapper from scrolling when the fixed side navigation hovered over
let sidebar = document.querySelector("body.fixed-nav .sidebar");
if (sidebar) {
  sidebar.addEventListener("wheel", function (e) {
    if (window.innerWidth > 768) {
      this.scrollTop += (e.deltaY < 0 ? -1 : 1) * 30;
      e.preventDefault();
    }
  });
}

// Scroll to top button appear
document.addEventListener("scroll", function () {
  let scrollDistance = window.scrollY;
  let scrollBtn = document.querySelector(".scroll-to-top");
  if (scrollBtn) {
    if (scrollDistance > 100) {
      scrollBtn.style.display = "block";
    } else {
      scrollBtn.style.display = "none";
    }
  }
});

// Smooth scrolling using native JS
document.querySelectorAll("a.scroll-to-top").forEach(function (anchor) {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();
    let target = document.querySelector(this.getAttribute("href"));
    if (target) {
      target.scrollIntoView({ behavior: "smooth" });
    }
  });
});

// Modal Javascript
document.addEventListener("DOMContentLoaded", function () {
  ["myBtn", "modalLong", "modalScroll", "modalCenter"].forEach(function (id) {
    let btn = document.getElementById(id);
    if (btn) {
      btn.addEventListener("click", function () {
        let modalEl = document.querySelector(".modal");
        if (modalEl) {
          new bootstrap.Modal(modalEl).show();
        }
      });
    }
  });
});

// Popover Javascript
document.addEventListener("DOMContentLoaded", function () {
  // Popover umum
  document.querySelectorAll('[data-bs-toggle="popover"]').forEach(function (popoverTriggerEl) {
    new bootstrap.Popover(popoverTriggerEl);
  });

  // Popover dismiss saat kehilangan fokus
  document.querySelectorAll(".popover-dismiss").forEach(function (popoverTriggerEl) {
    new bootstrap.Popover(popoverTriggerEl, { trigger: "focus" });
  });
});

// Version in Sidebar
let version = document.getElementById("version-ruangadmin");
if (version) {
  version.innerHTML = "Version 1.1";
}
