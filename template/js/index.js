(function() {

    // Token select
    var values = document.querySelectorAll(".lap-info-value > input");

    [].forEach.call(values, function(element) {
        element.addEventListener("click", handler);
    });

    function handler(evt) {
        this.select();
    }

    // Activtion
    var activate = document.getElementById("js-activate");

    if ( activate ) {
        activate.addEventListener("click", sendActivate);
    }

    function sendActivate(evt) {
        evt.preventDefault();

        var xhr          = new XMLHttpRequest(),
            notification = document.createElement("div"),
            target       = document.getElementById("js-activate-form"),
            email        = target.querySelector("input");

        if ( email.value === "" ) {
            notification.className = "lap-notification error";
            notification.appendChild(document.createTextNode("Email is required."));
            target.parentNode.insertBefore(notification, target);
            fadeAnimate(notification);
            return;
        }

        xhr.onload = function() {
            var json = JSON.parse(xhr.responseText);

            if ( json.code == 400 ) {
                notification.className = "lap-notification error";
            } else {
                notification.className = "lap-notification success";
                email.value            = "";
            }
            notification.appendChild(document.createTextNode(json.message));
            target.parentNode.insertBefore(notification, target);
            fadeAnimate(notification);
        };

        xhr.open("POST", target.action, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("email=" + encodeURIComponent(email.value));
    }

    // fade
    var fades = document.querySelectorAll(".lap-notification");

    [].forEach.call(fades, fadeAnimate);

    function fadeAnimate(node) {
        node.addEventListener("webkitAnimationEnd", function() {
            node.style.display = "none";
        });
    }

    // back button
    var backButtons = document.querySelectorAll(".lap-back-button");

    [].forEach.call(backButtons, function(button) {
        button.addEventListener("click", backHandler);
    });

    function backHandler(evt) {
        var element = evt.target,
            form    = element.parentNode;

        while ( form ) {
            if ( form.tagName === "FORM" ) {
                break;
            }

            form = form.parentNode;
        }

        if ( ! form ) {
            return;
        }

        form.action = element.getAttribute("data-backurl");
        form.submit();
    }

    // tabs
    (function(tabs, tabContents) {
        if ( tabs.length === 0 ) {
            return;
        }
        var activeTab     = tabs[0].parentNode;
        var activeContent = tabContents[0];

        [].forEach.call(tabs, function(tab) {
            tab.addEventListener("click", function(evt) {
                evt.preventDefault();
                activeTab.classList.remove("pure-menu-selected");
                activeContent.classList.add("lap-hidden");

                activeTab = this.parentNode;
                activeContent = document.getElementById(this.className + "-content");

                activeTab.classList.add("pure-menu-selected");
                activeContent.classList.remove("lap-hidden");
            });
        });
    })(document.querySelectorAll(".lap-tabs a"),
       document.querySelectorAll(".lap-tab-content"));


    function ModalWindow(btn, template, factory) {
        this.btn = btn;
        this.template = Retriever.make(template.innerHTML);
        this.factory = factory || function() {};
        this.layer = document.querySelector(".lap-overlay");
        this.wrapper = document.createElement("div");
        this.modal = null;

        // remove template node
        template.parentNode.removeChild(template);

        this.init();
    }

    ModalWindow.prototype.init = function() {
        this.btn.addEventListener("click", function(evt) {
            evt.preventDefault();
            var obj = this.factory() || {};
            var html = this.template.parse(obj);

            this.wrapper.innerHTML = html;
            this.modal = this.wrapper.querySelector(".lap-section");
            [].forEach.call(this.modal.querySelectorAll("[data-close]"), function(element) {
                element.addEventListener("click", this);
            }.bind(this));
            this.layer.style.display = "block";
            document.body.appendChild(this.modal);
        }.bind(this));
    };

    ModalWindow.prototype.handleEvent = function(evt) {
        evt.preventDefault();
        evt.currentTarget.removeEventListener("click", this);

        document.body.removeChild(this.modal);
        this.modal = null;
        this.layer.style.display = "none";
    };

    // delete modal
    var deleteBtn = document.getElementById("lap-delete-account");
    if ( deleteBtn ) {
        new ModalWindow(deleteBtn, document.getElementById("delete-account-modal"), function() {});
    }

    // email modal
    var emailBtn = document.getElementById("lap-email-activate");
    if ( emailBtn ) {
        new ModalWindow(emailBtn, document.getElementById("email-confirm-modal"), function() {
            return {
                email: document.getElementById("lap-account-emails").value
            };
        });
    }

    // userName modal
    var userBtn = document.getElementById("lap-change-username");
    if ( userBtn ) {
        new ModalWindow(userBtn, document.getElementById("modify-username-modal"), function() {
            return {
                userName: document.getElementById("lap-account-username").value
            };
        });
    }

    // password modal
    var passwordBtn = document.getElementById("lap-change-password");
    if ( passwordBtn ) {
        new ModalWindow(passwordBtn, document.getElementById("password-confirm-modal"), function() {
            return {
                password: document.getElementById("lap-account-password").value,
                passwordConfirm: document.getElementById("lap-account-password-confirm").value
            };
        });
    }

    // subscribe modal
    var subscribe = document.getElementById("lap-subscribe-user");
    if ( subscribe ) {
        new ModalWindow(subscribe, document.getElementById("subscribe-modal"), function() {});
    }

})();
