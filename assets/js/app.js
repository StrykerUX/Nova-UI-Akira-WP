class App {
    initComponents() {
        // Check if lucide is defined before using it
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            lucide.createIcons();
        }

        // Preloader
        $(window).on("load", function() {
            $("#status").fadeOut();
            $("#preloader").delay(350).fadeOut("slow");
        });

        // Initialize components
        [...document.querySelectorAll('[data-bs-toggle="popover"]')].map(e => new bootstrap.Popover(e));
        [...document.querySelectorAll('[data-bs-toggle="tooltip"]')].map(e => new bootstrap.Tooltip(e));
        [...document.querySelectorAll(".offcanvas")].map(e => new bootstrap.Offcanvas(e));

        // Toast placement
        var e = document.getElementById("toastPlacement");
        if (e) {
            document.getElementById("selectToastPlacement").addEventListener("change", function() {
                e.dataset.originalClass || (e.dataset.originalClass = e.className);
                e.className = e.dataset.originalClass + " " + this.value;
            });
        }

        // Initialize toasts
        [].slice.call(document.querySelectorAll(".toast")).map(function(e) {
            return new bootstrap.Toast(e);
        });

        // Live alert demo
        const alertPlaceholder = document.getElementById("liveAlertPlaceholder");
        const alertTrigger = document.getElementById("liveAlertBtn");
        
        if (alertTrigger) {
            alertTrigger.addEventListener("click", () => {
                var alertMessage = "Nice, you triggered this alert message!";
                var alertType = "success";
                const wrapper = document.createElement("div");
                wrapper.innerHTML = [
                    `<div class="alert alert-${alertType} alert-dismissible" role="alert">`,
                    `   <div>${alertMessage}</div>`,
                    '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                    "</div>"
                ].join("");
                alertPlaceholder.append(wrapper);
            });
        }

        // RTL support
        if (document.getElementById("app-style") && 
            document.getElementById("app-style").href.includes("rtl.min.css")) {
            document.getElementsByTagName("html")[0].dir = "rtl";
        }
    }

    initPortletCard() {
        var cardSelector = ".card";
        
        // Card Remove
        $(document).on("click", '.card a[data-bs-toggle="remove"]', function(e) {
            e.preventDefault();
            var card = $(this).closest(cardSelector);
            var cardParent = card.parent();
            card.remove();
            if (cardParent.children().length === 0) {
                cardParent.remove();
            }
        });

        // Card Reload
        $(document).on("click", '.card a[data-bs-toggle="reload"]', function(e) {
            e.preventDefault();
            var card = $(this).closest(cardSelector);
            card.append('<div class="card-disabled"><div class="card-portlets-loader"></div></div>');
            var loadingOverlay = card.find(".card-disabled");
            setTimeout(function() {
                loadingOverlay.fadeOut("fast", function() {
                    loadingOverlay.remove();
                });
            }, 500 + 5 * Math.random() * 300);
        });
    }

    initMultiDropdown() {
        $('.dropdown-menu a.dropdown-toggle').on("click", function() {
            var submenu = $(this).next(".dropdown-menu");
            var otherSubmenus = $(this).parent().parent().find(".dropdown-menu").not(submenu);
            otherSubmenus.removeClass("show");
            otherSubmenus.parent().find(".dropdown-toggle").removeClass("show");
            return false;
        });
    }

    initLeftSidebar() {
        // Skip if sidebar doesn't exist
        if (!$(".side-nav").length) return;

        var sideNavCollapse = $(".side-nav li .collapse");
        
        // Prevent default action on collapse toggle
        $(".side-nav li [data-bs-toggle='collapse']").on("click", function(e) {
            return false;
        });

        // Collapse handling
        sideNavCollapse.on({
            "show.bs.collapse": function(e) {
                var parentCollapses = $(e.target).parents(".collapse.show");
                $(".side-nav .collapse.show").not(e.target).not(parentCollapses).collapse("hide");
            }
        });

        // Active link handling
        $(".side-nav a").each(function() {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().addClass("active");
                $(this).parent().parent().parent().addClass("show");
                $(this).parent().parent().parent().parent().addClass("active");

                var mainNav = $(this).parent().parent().parent().parent().parent().parent();
                if (mainNav.attr("id") !== "sidebar-menu") {
                    mainNav.addClass("show");
                }

                $(this).parent().parent().parent().parent().parent().parent().parent().addClass("active");
                
                var subNav = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent();
                if (subNav.attr("id") !== "wrapper") {
                    subNav.addClass("show");
                }
                
                var lastNav = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent();
                if (!lastNav.is("body")) {
                    lastNav.addClass("active");
                }
            }
        });

        // Scroll to active menu item
        setTimeout(function() {
            var activeElement = document.querySelector("li.active .active");
            
            function smoothScroll() {
                var currentTime = elapsed += 20;
                var startPosition = startY;
                var endPosition = targetY;
                
                var position = (currentTime / duration < 1) 
                    ? endPosition / 2 * (currentTime / duration) * (currentTime / duration) + startPosition 
                    : -endPosition / 2 * ((currentTime / duration - 1) * ((currentTime / duration - 1) - 2) - 1) + startPosition;
                
                element.scrollTop = position;
                
                if (currentTime < duration) {
                    setTimeout(smoothScroll, 20);
                }
            }

            if (activeElement != null) {
                var element = document.querySelector(".sidenav-menu .simplebar-content-wrapper");
                var targetY = activeElement.offsetTop - 300;
                
                if (element && targetY > 100) {
                    var startY = element.scrollTop;
                    var distance = targetY - startY;
                    var duration = 600;
                    var elapsed = 0;
                    
                    smoothScroll();
                }
            }
        }, 200);
    }

    initTopbarMenu() {
        // Skip if topbar menu doesn't exist
        if (!$(".navbar-nav").length) return;

        // Active link
        $(".navbar-nav li a").each(function() {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().parent().addClass("active");
                $(this).parent().parent().parent().parent().addClass("active");
                $(this).parent().parent().parent().parent().parent().parent().addClass("active");
            }
        });

        // Toggle navbar
        $(".navbar-toggle").on("click", function() {
            $(this).toggleClass("open");
            $("#navigation").slideToggle(400);
        });
    }

    initfullScreenListener() {
        var fullscreenButton = document.querySelector('[data-toggle="fullscreen"]');
        
        if (fullscreenButton) {
            fullscreenButton.addEventListener("click", function(e) {
                e.preventDefault();
                document.body.classList.toggle("fullscreen-enable");
                
                if (!document.fullscreenElement && 
                    !document.mozFullScreenElement && 
                    !document.webkitFullscreenElement) {
                    // Request fullscreen
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen();
                    } else if (document.documentElement.mozRequestFullScreen) {
                        document.documentElement.mozRequestFullScreen();
                    } else if (document.documentElement.webkitRequestFullscreen) {
                        document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                    }
                } else {
                    // Exit fullscreen
                    if (document.cancelFullScreen) {
                        document.cancelFullScreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.webkitCancelFullScreen) {
                        document.webkitCancelFullScreen();
                    }
                }
            });
        }
    }

    initFormValidation() {
        // Loop all forms with needs-validation class
        document.querySelectorAll(".needs-validation").forEach(form => {
            form.addEventListener("submit", event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add("was-validated");
            }, false);
        });
    }

    initFormAdvance() {
        // Input masks (if available)
        if (typeof Inputmask !== 'undefined') {
            document.querySelectorAll('[data-toggle="input-mask"]').forEach(element => {
                var maskFormat = element.getAttribute("data-mask-format").toString().replaceAll("0", "9");
                element.setAttribute("data-mask-format", maskFormat);
                const mask = new Inputmask(maskFormat);
                mask.mask(element);
            });
        }

        // Choices.js (if available)
        if (typeof Choices !== 'undefined') {
            document.querySelectorAll("[data-choices]").forEach(function(element) {
                var config = {};
                var attributes = element.attributes;
                
                if (attributes["data-choices-groups"]) {
                    config.placeholderValue = "This is a placeholder set in the config";
                }
                if (attributes["data-choices-search-false"]) {
                    config.searchEnabled = false;
                }
                if (attributes["data-choices-search-true"]) {
                    config.searchEnabled = true;
                }
                if (attributes["data-choices-removeItem"]) {
                    config.removeItemButton = true;
                }
                if (attributes["data-choices-sorting-false"]) {
                    config.shouldSort = false;
                }
                if (attributes["data-choices-sorting-true"]) {
                    config.shouldSort = true;
                }
                if (attributes["data-choices-multiple-remove"]) {
                    config.removeItemButton = true;
                }
                if (attributes["data-choices-limit"]) {
                    config.maxItemCount = attributes["data-choices-limit"].value.toString();
                }
                if (attributes["data-choices-editItem-true"]) {
                    config.maxItemCount = true;
                }
                if (attributes["data-choices-editItem-false"]) {
                    config.maxItemCount = false;
                }
                if (attributes["data-choices-text-unique-true"]) {
                    config.duplicateItemsAllowed = false;
                }
                if (attributes["data-choices-text-disabled-true"]) {
                    config.addItems = false;
                }

                if (attributes["data-choices-text-disabled-true"]) {
                    new Choices(element, config).disable();
                } else {
                    new Choices(element, config);
                }
            });
        }

        // Select2 (if available)
        if (jQuery().select2) {
            $('[data-toggle="select2"]').select2();
        }

        // Input masks with jQuery mask (if available)
        if (jQuery().mask) {
            $('[data-toggle="input-mask"]').each(function(idx, elem) {
                var maskFormat = $(elem).data("maskFormat");
                var reverse = $(elem).data("reverse");
                if (reverse != null) {
                    $(elem).mask(maskFormat, { reverse: reverse });
                } else {
                    $(elem).mask(maskFormat);
                }
            });
        }

        // Flatpickr and Timepickr (date/time pickers)
        var pickers = document.querySelectorAll("[data-provider]");
        
        Array.from(pickers).forEach(function(element) {
            var providerName = element.getAttribute("data-provider");
            
            if (providerName === "flatpickr") {
                // Initialize flatpickr
                var attributes = element.attributes;
                var config = { disableMobile: "true" };
                
                // Process attributes to build config
                if (attributes["data-date-format"]) {
                    config.dateFormat = attributes["data-date-format"].value.toString();
                }
                if (attributes["data-enable-time"]) {
                    config.enableTime = true;
                    config.dateFormat = attributes["data-date-format"].value.toString() + " H:i";
                }
                if (attributes["data-altFormat"]) {
                    config.altInput = true;
                    config.altFormat = attributes["data-altFormat"].value.toString();
                }
                if (attributes["data-minDate"]) {
                    config.minDate = attributes["data-minDate"].value.toString();
                    config.dateFormat = attributes["data-date-format"].value.toString();
                }
                if (attributes["data-maxDate"]) {
                    config.maxDate = attributes["data-maxDate"].value.toString();
                    config.dateFormat = attributes["data-date-format"].value.toString();
                }
                if (attributes["data-deafult-date"]) {
                    config.defaultDate = attributes["data-deafult-date"].value.toString();
                    config.dateFormat = attributes["data-date-format"].value.toString();
                }
                if (attributes["data-multiple-date"]) {
                    config.mode = "multiple";
                    config.dateFormat = attributes["data-date-format"].value.toString();
                }
                if (attributes["data-range-date"]) {
                    config.mode = "range";
                    config.dateFormat = attributes["data-date-format"].value.toString();
                }
                if (attributes["data-inline-date"]) {
                    config.inline = true;
                    config.defaultDate = attributes["data-deafult-date"].value.toString();
                    config.dateFormat = attributes["data-date-format"].value.toString();
                }
                if (attributes["data-disable-date"]) {
                    var disabledDates = [];
                    disabledDates.push(attributes["data-disable-date"].value);
                    config.disable = disabledDates.toString().split(",");
                }
                if (attributes["data-week-number"]) {
                    var wkNumber = [];
                    wkNumber.push(attributes["data-week-number"].value);
                    config.weekNumbers = true;
                }
                
                if (typeof flatpickr !== 'undefined') {
                    flatpickr(element, config);
                }
            } else if (providerName === "timepickr") {
                // Initialize timepickr
                var attributes = element.attributes;
                var config = {};
                
                if (attributes["data-time-basic"]) {
                    config.enableTime = true;
                    config.noCalendar = true;
                    config.dateFormat = "H:i";
                }
                if (attributes["data-time-hrs"]) {
                    config.enableTime = true;
                    config.noCalendar = true;
                    config.dateFormat = "H:i";
                    config.time_24hr = true;
                }
                if (attributes["data-min-time"]) {
                    config.enableTime = true;
                    config.noCalendar = true;
                    config.dateFormat = "H:i";
                    config.minTime = attributes["data-min-time"].value.toString();
                }
                if (attributes["data-max-time"]) {
                    config.enableTime = true;
                    config.noCalendar = true;
                    config.dateFormat = "H:i";
                    config.minTime = attributes["data-max-time"].value.toString();
                }
                if (attributes["data-default-time"]) {
                    config.enableTime = true;
                    config.noCalendar = true;
                    config.dateFormat = "H:i";
                    config.defaultDate = attributes["data-default-time"].value.toString();
                }
                if (attributes["data-time-inline"]) {
                    config.enableTime = true;
                    config.noCalendar = true;
                    config.defaultDate = attributes["data-time-inline"].value.toString();
                    config.inline = true;
                }
                
                if (typeof flatpickr !== 'undefined') {
                    flatpickr(element, config);
                }
            }
        });
    }

    init() {
        this.initComponents();
        this.initPortletCard();
        this.initMultiDropdown();
        this.initLeftSidebar();
        this.initTopbarMenu();
        this.initfullScreenListener();
        this.initFormValidation();
        this.initFormAdvance();
    }
}

class ThemeCustomizer {
    constructor() {
        this.html = document.getElementsByTagName("html")[0];
        this.config = {};
        this.defaultConfig = window.config || {};
    }

    initConfig() {
        // Make sure defaultConfig exists
        if (window.defaultConfig) {
            this.defaultConfig = JSON.parse(JSON.stringify(window.defaultConfig));
        } else {
            // Set default values if not defined
            this.defaultConfig = {
                theme: 'light',
                nav: 'vertical',
                layout: {
                    mode: 'fluid',
                    position: 'fixed'
                },
                topbar: {
                    color: 'light'
                },
                menu: {
                    color: 'dark'
                },
                sidenav: {
                    size: 'default'
                }
            };
            window.defaultConfig = this.defaultConfig;
        }
        
        // Set config from storage or defaults
        if (window.config) {
            this.config = JSON.parse(JSON.stringify(window.config));
        } else {
            this.config = JSON.parse(JSON.stringify(this.defaultConfig));
            window.config = this.config;
        }
        
        this.setSwitchFromConfig();
    }

    initTwoColumn() {
        if (!$("#two-col-sidenav-main").length) return;
        
        var mainMenuLinks = $("#two-col-sidenav-main .side-nav-link");
        var menuItems = $(".sidenav-menu-item");
        var subMenus = $(".sidenav-menu-item .sub-menu");
        var collapseElements = $("#two-col-menu menu-item .collapse");
        
        // Handle collapsible items
        collapseElements.on({
            "show.bs.collapse": function() {
                var otherCollapses = $(this).closest(subMenus).closest(subMenus).find(collapseElements);
                (otherCollapses.length ? otherCollapses : collapseElements).not($(this)).collapse("hide");
            }
        });
        
        // Handle menu links
        mainMenuLinks.on("click", function(e) {
            var targetMenu = $($(this).attr("href"));
            
            if (targetMenu.length) {
                e.preventDefault();
                mainMenuLinks.removeClass("active");
                $(this).addClass("active");
                menuItems.removeClass("d-block");
                targetMenu.addClass("d-block");
                
                if (window.innerWidth >= 1040) {
                    self.changeLeftbarSize("default");
                }
                return true;
            }
        });
        
        // Set active menu based on URL
        var currentUrl = window.location.href;
        
        // Activate main menu links if they match the current URL
        mainMenuLinks.each(function() {
            if (this.href === currentUrl) {
                $(this).addClass("active");
            }
        });
        
        // Activate submenu links
        $("#two-col-menu a").each(function() {
            if (this.href === currentUrl) {
                $(this).addClass("active");
                $(this).parent().addClass("active");
                
                // Expand parent collapses
                $(this).parent().parent().parent().addClass("show");
                $(this).parent().parent().parent().parent().addClass("active");
                
                // Handle parent elements
                var parents = {
                    parent1: $(this).parent().parent().parent().parent().parent().parent(),
                    parent2: $(this).parent().parent().parent().parent().parent().parent().parent(),
                    parent3: $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent(),
                    parent4: $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent()
                };
                
                if (parents.parent1.attr("id") !== "sidebar-menu") {
                    parents.parent1.addClass("show");
                }
                
                parents.parent2.addClass("active");
                
                if (parents.parent3.attr("id") !== "wrapper") {
                    parents.parent3.addClass("show");
                }
                
                if (!parents.parent4.is("body")) {
                    parents.parent4.addClass("active");
                }
                
                // Find and activate the corresponding main menu link
                var linkedMenu = null;
                var targetMenu = "#" + $(this).parents(".sidenav-menu-item").attr("id");
                
                $("#two-col-sidenav-main .side-nav-link").each(function() {
                    if ($(this).attr("href") === targetMenu) {
                        linkedMenu = $(this);
                    }
                });
                
                if (linkedMenu) {
                    linkedMenu.trigger("click");
                }
            }
        });
    }

    changeMenuColor(color) {
        this.config.menu.color = color;
        this.html.setAttribute("data-menu-color", color);
        this.setSwitchFromConfig();
    }

    changeLeftbarSize(size, saveToConfig = true) {
        this.html.setAttribute("data-sidenav-size", size);
        
        if (saveToConfig) {
            this.config.sidenav.size = size;
            this.setSwitchFromConfig();
        }
    }

    changeLayoutMode(mode, saveToConfig = true) {
        this.html.setAttribute("data-layout-mode", mode);
        
        if (saveToConfig) {
            this.config.layout.mode = mode;
            this.setSwitchFromConfig();
        }
    }

    changeLayoutColor(theme) {
        this.config.theme = theme;
        this.html.setAttribute("data-bs-theme", theme);
        this.setSwitchFromConfig();
    }

    changeTopbarColor(color) {
        this.config.topbar.color = color;
        this.html.setAttribute("data-topbar-color", color);
        this.setSwitchFromConfig();
    }

    resetTheme() {
        if (window.defaultConfig) {
            this.config = JSON.parse(JSON.stringify(window.defaultConfig));
            this.changeMenuColor(this.config.menu.color);
            this.changeLeftbarSize(this.config.sidenav.size);
            this.changeLayoutColor(this.config.theme);
            this.changeLayoutMode(this.config.layout.mode);
            this.changeTopbarColor(this.config.topbar.color);
            this._adjustLayout();
        }
    }

    initSwitchListener() {
        var self = this;
        
        // Menu Color Switch
        document.querySelectorAll("input[name=data-menu-color]").forEach(function(elem) {
            elem.addEventListener("change", function() {
                self.changeMenuColor(elem.value);
            });
        });
        
        // Sidenav Size Switch
        document.querySelectorAll("input[name=data-sidenav-size]").forEach(function(elem) {
            elem.addEventListener("change", function() {
                self.changeLeftbarSize(elem.value);
            });
        });
        
        // Theme Switch
        document.querySelectorAll("input[name=data-bs-theme]").forEach(function(elem) {
            elem.addEventListener("change", function() {
                self.changeLayoutColor(elem.value);
            });
        });
        
        // Layout Mode Switch
        document.querySelectorAll("input[name=data-layout-mode]").forEach(function(elem) {
            elem.addEventListener("change", function() {
                self.changeLayoutMode(elem.value);
            });
        });
        
        // Layout Type Switch
        document.querySelectorAll("input[name=data-layout]").forEach(function(elem) {
            elem.addEventListener("change", function() {
                if (elem.value === "horizontal") {
                    window.location = "layouts-horizontal.html";
                } else {
                    window.location = "index.html";
                }
            });
        });
        
        // Topbar Color Switch
        document.querySelectorAll("input[name=data-topbar-color]").forEach(function(elem) {
            elem.addEventListener("change", function() {
                self.changeTopbarColor(elem.value);
            });
        });
        
        // Light/Dark Mode Switch
        var lightDarkBtn = document.getElementById("light-dark-mode");
        if (lightDarkBtn) {
            lightDarkBtn.addEventListener("click", function() {
                if (self.config.theme === "light") {
                    self.changeLayoutColor("dark");
                } else {
                    self.changeLayoutColor("light");
                }
            });
        }
        
        // Reset Layout
        var resetBtn = document.querySelector("#reset-layout");
        if (resetBtn) {
            resetBtn.addEventListener("click", function() {
                self.resetTheme();
            });
        }
        
        // Sidebar Toggle Button
        var sidenavToggleBtn = document.querySelector(".sidenav-toggle-button");
        if (sidenavToggleBtn) {
            sidenavToggleBtn.addEventListener("click", function() {
                var size = self.config.sidenav.size;
                var currentSize = self.html.getAttribute("data-sidenav-size", size);
                
                if (currentSize === "full") {
                    self.showBackdrop();
                } else if (size === "fullscreen") {
                    if (currentSize === "fullscreen") {
                        self.changeLeftbarSize(size === "fullscreen" ? "default" : size, false);
                    } else {
                        self.changeLeftbarSize("fullscreen", false);
                    }
                } else if (currentSize === "condensed") {
                    self.changeLeftbarSize(size === "condensed" ? "default" : size, false);
                } else {
                    self.changeLeftbarSize("condensed", false);
                }
                
                self.html.classList.toggle("sidebar-enable");
            });
        }
        
        // Close Button for Full Sidebar
        var closeFullSidebarBtn = document.querySelector(".button-close-fullsidebar");
        if (closeFullSidebarBtn) {
            closeFullSidebarBtn.addEventListener("click", function() {
                self.html.classList.remove("sidebar-enable");
                self.hideBackdrop();
            });
        }
        
        // Hover Button for Sidebar
        document.querySelectorAll(".button-sm-hover").forEach(function(btn) {
            btn.addEventListener("click", function() {
                var size = self.config.sidenav.size;
                
                if (self.html.getAttribute("data-sidenav-size", size) === "sm-hover-active") {
                    self.changeLeftbarSize("sm-hover", false);
                } else {
                    self.changeLeftbarSize("sm-hover-active", false);
                }
            });
        });
    }

    showBackdrop() {
        const backdrop = document.createElement("div");
        backdrop.id = "custom-backdrop";
        backdrop.classList = "offcanvas-backdrop fade show";
        document.body.appendChild(backdrop);
        document.body.style.overflow = "hidden";
        
        if (window.innerWidth > 767) {
            document.body.style.paddingRight = "15px";
        }
        
        const self = this;
        backdrop.addEventListener("click", function() {
            self.html.classList.remove("sidebar-enable");
            self.hideBackdrop();
        });
    }

    hideBackdrop() {
        var backdrop = document.getElementById("custom-backdrop");
        
        if (backdrop) {
            document.body.removeChild(backdrop);
            document.body.style.overflow = null;
            document.body.style.paddingRight = null;
        }
    }

    initWindowSize() {
        var self = this;
        
        window.addEventListener("resize", function() {
            self._adjustLayout();
        });
    }

    _adjustLayout() {
        var self = this;
        
        if (window.innerWidth <= 767.98) {
            self.changeLeftbarSize("full", false);
        } else if (window.innerWidth > 767 && window.innerWidth <= 1140) {
            if (self.config.sidenav.size !== "full" && self.config.sidenav.size !== "fullscreen") {
                if (self.config.sidenav.size === "sm-hover") {
                    self.changeLeftbarSize("condensed");
                } else {
                    self.changeLeftbarSize("condensed", false);
                }
            }
        } else {
            self.changeLeftbarSize(self.config.sidenav.size);
            self.changeLayoutMode(self.config.layout.mode);
        }
    }

    setSwitchFromConfig() {
        if (typeof sessionStorage !== 'undefined') {
            try {
                sessionStorage.setItem("__BORON_CONFIG__", JSON.stringify(this.config));
            } catch (e) {
                console.error("Error saving config to sessionStorage:", e);
            }
        }
        
        // Uncheck all checkboxes first
        document.querySelectorAll(".right-bar input[type=checkbox]").forEach(function(elem) {
            elem.checked = false;
        });
        
        // Get settings from config
        var settings = {
            layout: document.querySelector("input[type=radio][name=data-layout][value=" + this.config.nav + "]"),
            theme: document.querySelector("input[type=radio][name=data-bs-theme][value=" + this.config.theme + "]"),
            layoutMode: document.querySelector("input[type=radio][name=data-layout-mode][value=" + this.config.layout.mode + "]"),
            topbarColor: document.querySelector("input[type=radio][name=data-topbar-color][value=" + this.config.topbar.color + "]"),
            menuColor: document.querySelector("input[type=radio][name=data-menu-color][value=" + this.config.menu.color + "]"),
            sidenavSize: document.querySelector("input[type=radio][name=data-sidenav-size][value=" + this.config.sidenav.size + "]")
        };
        
        // Set checked for radio buttons
        if (settings.layout) settings.layout.checked = true;
        if (settings.theme) settings.theme.checked = true;
        if (settings.layoutMode) settings.layoutMode.checked = true;
        if (settings.topbarColor) settings.topbarColor.checked = true;
        if (settings.menuColor) settings.menuColor.checked = true;
        if (settings.sidenavSize) settings.sidenavSize.checked = true;
    }

    init() {
        this.initConfig();
        this.initTwoColumn();
        this.initSwitchListener();
        this.initWindowSize();
        this._adjustLayout();
        this.setSwitchFromConfig();
    }
}

document.addEventListener("DOMContentLoaded", function() {
    (new App).init();
    (new ThemeCustomizer).init();
});

const customJS = () => {
    // Mouse stop event simulation
    var mouseStopTimer;
    document.addEventListener("mousemove", function(event) {
        clearTimeout(mouseStopTimer);
        mouseStopTimer = setTimeout(function() {
            var mouseStopEvent = new CustomEvent("mousestop", {
                detail: {
                    clientX: event.clientX,
                    clientY: event.clientY
                },
                bubbles: true,
                cancelable: true
            });
            event.target.dispatchEvent(mouseStopEvent);
        }, 100);
    });

    // Dismissible components
    {
        const dismissButtons = document.querySelectorAll("[data-dismissible]");
        dismissButtons.forEach(button => {
            button.addEventListener("click", event => {
                var selector = button.getAttribute("data-dismissible");
                const target = document.querySelector(selector);
                if (target) {
                    target.remove();
                }
            });
        });
    }

    // Toggle components
    {
        const toggleContainers = document.querySelectorAll("[data-toggler]");
        
        const showElement = (element) => {
            element.classList.remove("d-none");
        };
        
        const hideElement = (element) => {
            element.classList.add("d-none");
        };
        
        const toggleElements = (onElement, offElement, isOn) => {
            console.info(onElement, offElement, isOn);
            if (onElement && offElement) {
                if (isOn) {
                    showElement(onElement);
                    hideElement(offElement);
                } else {
                    showElement(offElement);
                    hideElement(onElement);
                }
            }
        };
        
        toggleContainers.forEach(container => {
            const onElement = container.querySelector("[data-toggler-on]");
            const offElement = container.querySelector("[data-toggler-off]");
            let isOn = container.getAttribute("data-toggler") === "on";
            
            if (onElement) {
                onElement.addEventListener("click", () => {
                    isOn = false;
                    toggleElements(onElement, offElement, isOn);
                });
            }
            
            if (offElement) {
                offElement.addEventListener("click", () => {
                    isOn = true;
                    toggleElements(onElement, offElement, isOn);
                });
            }
            
            // Initialize state
            toggleElements(onElement, offElement, isOn);
        });
    }

    // Touch Spin components
    {
        const touchSpins = document.querySelectorAll("[data-touchspin]");
        
        touchSpins.forEach(spinner => {
            const minusButton = spinner.querySelector(".minus");
            const plusButton = spinner.querySelector(".plus");
            const inputField = spinner.querySelector("input");
            
            if (inputField) {
                const minValue = inputField.min.length !== 0 ? Number(inputField.min) : null;
                const maxValue = inputField.max.length !== 0 ? Number(inputField.max) : null;
                
                if (minusButton) {
                    minusButton.addEventListener("click", event => {
                        const newValue = Number.parseInt(inputField.value) - 1;
                        
                        if (minValue === null) {
                            inputField.value = newValue.toString();
                        } else if (newValue > minValue - 1) {
                            inputField.value = newValue.toString();
                        }
                    });
                }
                
                if (plusButton) {
                    plusButton.addEventListener("click", event => {
                        const newValue = Number.parseInt(inputField.value) + 1;
                        
                        if (maxValue === null) {
                            inputField.value = newValue.toString();
                        } else if (newValue < maxValue + 1) {
                            inputField.value = newValue.toString();
                        }
                    });
                }
            }
        });
    }
};

customJS();
