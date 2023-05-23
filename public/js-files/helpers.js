const alertData = {
    icons: {
        success: 'fa-circle-check',
        warning: 'fa-triangle-exclamation',
        // error: 'fa-circle-exclamation',
        error: 'fa-bug',
    },
    colors: {
        success: 'bg-success',
        warning: 'bg-warning',
        error: 'bg-danger',
    }
}

var options = {
    alert: {
        icon: null,
        color: null,
    },
    alertTimer: null,
};

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const toggleClassElement = (selector, text) => {
    let element = document.querySelector(selector);
    element.classList.toggle(text);
}

const addClassElement = (selector, text) => {
    let element = document.querySelector(selector);

    if (element.classList.contains(text))
        console.log(`${text} class is already exist!`);
    else
        element.classList.add(text);
}

const removeClassElement = (selector, text) => {
    let element = document.querySelector(selector);

    if (!element.classList.contains(text))
        console.log(`${text} class is not exist!`);
    else
        element.classList.remove(text);
}

const changeStyleElement = (selector, styleKey, value) => {
    let element = document.querySelector(selector);
    element.style[styleKey] = value;
}

const editClassBody = (text, bool) => {
    if (bool == true)
        addClassElement("body", text);
    else
        removeClassElement("body", text);
}

const loadingVisibility = (bool) => {
    if (bool == true) {
        addClassElement("body", "page-loading");
        addClassElement("body", "overflow-hidden");
        // changeStyleElement("#loading-page", "display", null);
    } else {
        removeClassElement("body", "page-loading");
        removeClassElement("body", "overflow-hidden");
        // changeStyleElement("#loading-page", "display", "none");
    }
}

const resetAlert = () => {
    let alertTitle = document.querySelector("#alert-title"),
        alertContent = document.querySelector("#alert-content");

    clearTimeout(options.alertTimer);
    removeClassElement("#alert-layout", "show");
    removeClassElement("#alert-icon", options.alert.icon);
    removeClassElement("#alert-layout", options.alert.color);
    alertTitle.innerHTML = "";
    alertContent.innerHTML = "";
    options.alert.icon = null;
    options.alert.color = null;
}

const showSlideAlert = (data) => {
    let alertTitle = document.querySelector("#alert-title"),
        alertContent = document.querySelector("#alert-content");

    if (data != null && data.title != undefined && data.title.trim() != "") {
        alertTitle.innerHTML = data?.title;
    }

    options.alert.icon = alertData.icons[data.type];
    options.alert.color = alertData.colors[data.type];
    alertContent.innerHTML = data?.content;
    addClassElement("#alert-icon", alertData.icons[data.type]);
    addClassElement("#alert-layout", alertData.colors[data.type]);
    addClassElement("#alert-layout", "show");

    options.alertTimer = setTimeout(() => {
        resetAlert();
    }, 3000);
}

const showAlert = (data) => {
    let alertType = document.querySelector("#swal2-alert-type"),
        alertContent = document.querySelector("#swal2-html-container"),
        alertActions = document.querySelector("#swal2-actions"),
        newAlert = {
            type: "",
            actions: "<div class=\"swal2-loader\"></div>",
        };

    if (data["type"] == "success") {
        newAlert.type = `
            <div class="swal2-icon swal2-success swal2-icon-show" style="display: flex;">
                <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
                <span class="swal2-success-line-tip"></span>
                <span class="swal2-success-line-long"></span>
                <div class="swal2-success-ring"></div>
                <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
                <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
            </div>
        `;

        newAlert.actions += `
            <button type="button" class="swal2-confirm btn btn-primary" style="display: inline-block;"onclick="liveCall('alertResult', true)">
                Ok, got it!
            </button>
        `;
    } else if (data["type"] == "error") {
        newAlert.type = `
            <div class="swal2-icon swal2-error swal2-icon-show" style="display: flex;">
                <span class="swal2-x-mark">
                    <span class="swal2-x-mark-line-left"></span>
                    <span class="swal2-x-mark-line-right"></span>
                </span>
            </div>
        `;

        newAlert.actions += `
            <button type="button" class="swal2-confirm btn btn-primary" style="display: inline-block;" onclick="liveCall('alertResult', true)">
                Ok, got it!
            </button>
        `;
    } else if (data["type"] == "question") {
        newAlert.type = `
            <div class="swal2-icon swal2-question swal2-icon-show" style="display: flex;">
                <div class="swal2-icon-content">?</div>
            </div>
        `;

        newAlert.actions += `
            <button type="button" class="swal2-confirm btn btn-primary" onclick="liveCall('alertResult', true)">Yes</button>
            <button type="button" class="swal2-deny btn btn-danger" onclick="liveCall('alertResult', false)">No</button>
        `;
    } else if (data["type"] == "warning") {
        newAlert.type = `
            <div class="swal2-icon swal2-warning swal2-icon-show" style="display: flex;">
                <div class="swal2-icon-content">!</div>
            </div>
        `;

        newAlert.actions += `
            <button type="button" class="swal2-confirm btn btn-primary" style="display: inline-block;" onclick="liveCall('alertResult', true)">
                Ok, got it!
            </button>
        `;
    } else {
        newAlert.type = `
            <div class="swal2-icon swal2-info swal2-icon-show" style="display: flex;">
                <div class="swal2-icon-content">i</div>
            </div>
        `;

        newAlert.actions += `
            <button type="button" class="swal2-confirm btn btn-primary" style="display: inline-block;" onclick="liveCall('alertResult', true)">
                Ok, got it!
            </button>
        `;
    }

    alertType.innerHTML = newAlert.type;
    alertActions.innerHTML = newAlert.actions;
    alertContent.innerHTML = data.content;
    removeClassElement("#app-alert", "d-none");
}

const hideAlert = () => {
    document.querySelector("#swal2-alert-type").innerHTML = "";
    document.querySelector("#swal2-html-container").innerHTML = "";
    document.querySelector("#swal2-actions").innerHTML = "";
    addClassElement("#app-alert", "d-none");
}

const initListener = () => {
    let elements = document.querySelectorAll("button, a, select");

    for (const element of elements) {
        if (element.hasAttribute("wire:click")) {
            element.addEventListener("click", e => {
                loadingVisibility(true);
            });
        } else if (element.hasAttribute("wire:change")) {
            element.addEventListener("change", e => {
                loadingVisibility(true);
            });
        }
    }
}

const liveComponent = () => {
    let appModule = document.querySelector("#live-component");
    let wireId = appModule.getAttribute("wire:id");
    return Livewire.find(wireId);
}

const liveCall = (callName, data) => {
    let component = liveComponent();
    component.call(callName, data);
}

const liveSet = (model, value) => {
    let component = liveComponent();
    component.set(model, value);
}

const liveSetModel = (element) => {
    let component = liveComponent(),
        tagName = $(element).prop("tagName"),
        type = $(element).attr("type"),
        model = $(element).attr("wire:model"),
        value = null;

    if (tagName == "INPUT" && type == "checkbox") {
        value = $(element).is(':checked');
    } else {
        value = $(element).val();
    }

    component.set(model, value);
}

const liveGet = (model) => {
    let component = liveComponent();
    component.get(model);
}

// const liveReloadElements = () => {
//     $("input, select").each(function (index, element) {
//         let model = $(element).attr("wire:model");
//         if (model != undefined) {
//             liveGet(model);
//             console.log(index, element);
//         }
//     });
// }

const getTableFilters = (filters) => {
    let dataObj = {};

    for (const filter of Object.keys(filters)) {
        dataObj[filter] = $(`#filter-${filter}`).val();
    }

    return dataObj;
}

const getTableParams = (id) => {
    return base_data.datatables[`table-${id}`].params;
}

const initSelect2 = (className = '.select-2-dropdown') => {
    if ($(className) != null && $(className).length > 0) {
        $(className).each(function (index, element) {
            let initData = {
                closeOnSelect: true,
            }, placeholder = $(element).attr("placeholder");

            if (placeholder != undefined) {
                initData.placeholder = placeholder;
            }

            $(className).select2(initData);
            $(element).on('change', function (e) {
                var data = $(element).select2("val"),
                    model = $(element).attr("wire:model");
                // $(element).select2("val", data).trigger("change");

                liveCall("changeValue", {
                    key: model,
                    value: data,
                });
            });

            // $(element).bind("DOMSubtreeModified", function () {
            //     if (base_data.initialized) {
            //         console.log('refreshed!');
            //         // $(element).select2('refresh');
            //         if ($(element).data('select2')) {
            //             $(element).select2("destroy").select2(initData);
            //         }
            //     }
            // });
        });
    }
}

const reInitSelect2 = (className = '.select-2-dropdown') => {
    if ($(className) != null && $(className).length > 0) {
        $(className).each(function (index, element) {
            let initData = {
                closeOnSelect: true,
            }, placeholder = $(element).attr("placeholder");

            if (placeholder != undefined) {
                initData.placeholder = placeholder;
            }

            if ($(element).attr("ignored") == "false" && !$(element).hasClass("select2-hidden-accessible") && base_data.initialized) {
                console.log('yoooo');
                // $(element).select2("destroy");
                // $(element).select2(initData);
                // $(element).select2("open");
                // if ($(element).data("select2") == undefined) {
                //     console.log('yoooo-2');
                //     // $(element).select2();
                //     // $(element).select2('refresh');
                //     $(element).select2(initData);
                //     $(element).select2("open");
                // }
            }
        })
    }
}

const setNotification = (response) => {
    // Notifications
    $("#notifications-count").html(`${response.alerts_count} notifications`);
    $("#all-notifications").html(response.alerts_content);

    // Logs
    $("#all-logs").html(response.logs_content);
}

const getUnreadNotifications = () => {
    $.ajax({
        type: "get",
        url: _urls.notification,
        dataType: "json",
        success: function (response) {
            setNotification(response);
        }, error: (error) => console.error(error),
    });
}

const setRead = (id) => {
    $.ajax({
        type: "post",
        url: _urls.setRead,
        data: {
            id: id,
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                console.log(response.message);
                setNotification(response.notifications);
            }
        }, error: (error) => console.error(error),
    });
}

const init_custom_attibute = () => {
    // Stop propagation
    $("[stop-propagation=true], [stop-propagation=\"\"]").each(function (index, element) {
        $(element).click(function (evt) {
            evt.stopPropagation();
        })
    });
}

const open_modal = (selector) => {
    $(selector).modal("show");
}

const close_modal = (selector) => {
    $(selector).modal("hide");
}

const upload_files = (model, files, callback = null) => {
    let component = liveComponent();
    component.uploadMultiple(model, files,
        function (success) {
            if (callback != null && typeof callback == "function")
                callback();
        },
        function (error) {
            console.log('error', error);
        },
    );
}

const changeLang = (lang) => {
    $.ajax({
        type: "get",
        url: `${_urls.changeLang}/${lang}`,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                location.reload();
            } else {
                showSlideAlert({
                    type: "error",
                    content: response.message,
                });
            }
        }, error: error => console.error(error)
    });
}

const getMessages = () => {
    $.ajax({
        type: "get",
        url: _urls.getMessagesView,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                $("#kt_drawer_chat_messenger_body").html(response.content);
            } else {
                showSlideAlert({
                    type: "error",
                    content: response.message,
                });
            }
        }, error: error => console.error(error)
    });
}

const saveMessage = (content, id = null, callback = null) => {
    let data = {
        message: {
            type: 1,
            content: content,
        }
    }

    if (id != null) {
        data.id = id;
    }

    $.ajax({
        type: "post",
        url: _urls.saveMessage,
        data: data,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                if (response.content != undefined)
                    $("#kt_drawer_chat_messenger_body").html(response.content);

                if (typeof callback == "function")
                    callback();
            } else {
                showSlideAlert({
                    type: "error",
                    content: response.message,
                });
            }
        }, error: error => console.error(error)
    });
}

const sendMessage = (element) => {
    if (event.type == "keyup" && (event.keyCode != 10 && event.keyCode != 13))
        return;

    let content = $("#kt_drawer_chat_messenger_textarea").val();

    if (content == "" || content == null)
        return;

    saveMessage(content);
    $('#kt_drawer_chat_messenger_textarea').val("");
}