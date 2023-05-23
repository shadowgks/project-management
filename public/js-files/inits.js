const $up = document.querySelector.bind(document);

const open_upload_dialog = (element, parentID) => {
    event.preventDefault();
    $up(`#${parentID} .upload-input`).click();
}

const upload_drag_leave = (element, parentID) => {
    event.preventDefault();
    $up(`#${parentID} .drop`).classList.remove("active");
}

const upload_drag_over = (element, parentID) => {
    event.preventDefault();
    $up(`#${parentID} .drop`).classList.add("active");
}

const upload_drag_drop = (element, parentID, model, callback = null) => {
    event.preventDefault();
    const files = event.dataTransfer.files;
    $up(`#${parentID} .upload-input`).files = files;
    $up(`#${parentID} .drop`).classList.remove("active");
    handleFileSelect(files, parentID, model, callback);
}

const importar_event = (element, parentID) => {
    $up(`#${parentID} .list-files`).innerHTML = "";
    $up(`#${parentID} footer`).classList.remove("hasFiles");
    $up(`#${parentID} .importar`).classList.remove("active");
    setTimeout(() => {
        $up(`#${parentID} .drop`).classList.remove("hidden");
    }, 500);
}

const get_uploaded_files = (element, parentID, model, callback = null) => {
    const files = event.target.files;
    handleFileSelect(files, parentID, model, callback);
}

const handleFileSelect = (files, parentID, model, callback = null) => {
    let add_files = new Promise(function (resolve, reject) {
        try {
            let template =
                `${Object.keys(files).map(file => `<div class="file file--${file}"><div class="name"><span>${files[file].name}</span></div><div class="progress active"></div><div class="done"><a href="" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 1000 1000"><g><path id="path" d="M500,10C229.4,10,10,229.4,10,500c0,270.6,219.4,490,490,490c270.6,0,490-219.4,490-490C990,229.4,770.6,10,500,10z M500,967.7C241.7,967.7,32.3,758.3,32.3,500C32.3,241.7,241.7,32.3,500,32.3c258.3,0,467.7,209.4,467.7,467.7C967.7,758.3,758.3,967.7,500,967.7z M748.4,325L448,623.1L301.6,477.9c-4.4-4.3-11.4-4.3-15.8,0c-4.4,4.3-4.4,11.3,0,15.6l151.2,150c0.5,1.3,1.4,2.6,2.5,3.7c4.4,4.3,11.4,4.3,15.8,0l308.9-306.5c4.4-4.3,4.4-11.3,0-15.6C759.8,320.7,752.7,320.7,748.4,325z"</g></svg></a></div></div>`).join("")}`;

            $up(`#${parentID} .drop`).classList.add("hidden");
            $up(`#${parentID} footer`).classList.add("hasFiles");
            $up(`#${parentID} .importar`).classList.add("active");
            setTimeout(() => {
                $up(`#${parentID} .list-files`).innerHTML = template;
            }, 1000);

            Object.keys(files).forEach((file, index) => {
                let load = 2000 + file * 2000;
                setTimeout(() => {
                    $up(`#${parentID} .file--${file}`).querySelector(".progress")
                        .classList
                        .remove(
                            "active");
                    $up(`#${parentID} .file--${file}`).querySelector(".done")
                        .classList.add(
                            "anim");

                    if ((files.length - 1) == index) {
                        resolve("Done");
                    }
                }, load);
            });
        } catch (error) {
            reject(error);
        }
    });

    add_files.then(() => {
        upload_files(model, files, (callback == null ? null : () => {
            liveCall(callback);
        }));
    }).catch(error => console.error(error));
}

const init_datatable = (id, route, columns, app_module_id, filters = null, d_options = {}) => {
    base_data.datatables[`table-${id}`] = {
        id: id,
        obj: null,
        columns: columns,
        route: route,
        app_module_id: app_module_id,
        params: {},
    };

    if (filters != null) {
        base_data.datatables[`table-${id}`].filters = filters;
    }

    ior_datatable(id, route, app_module_id, d_options);
}

const reload_datatable = (data) => {
    let type_of_data = typeof data;

    if (type_of_data == "string")
        base_data.datatables[`table-${data}`].obj.ajax.reload();
    else if (type_of_data == "object") {
        base_data.datatables[`table-${data.id}`].params = {};
        base_data.datatables[`table-${data.id}`].params = data;
        base_data.datatables[`table-${data.id}`].obj.ajax.reload({
            type: "POST",
        });
    }

    else
        console.error("Type of reloadTable data must be string or object!");
}

const ior_datatable = (id, route, app_module_id, d_options = {}) => {
    const funcData = (d) => {
        d.app_module_id = app_module_id;
        d.params = getTableParams(id);
        d.d_filters = (base_data.datatables[`table-${id}`].filters == undefined ? null : getTableFilters(base_data.datatables[`table-${id}`].filters));

        if (typeof d_options == "object" && Object.keys(d_options).length > 1)
            d.d_options = d_options;
    };

    base_data.datatables[`table-${id}`].obj = new DataTable(`#table-${id}`, {
        processing: true,
        serverSide: true,
        ajax: {
            url: route,
            type: "POST",
            data: funcData,
        },
        columns: base_data.datatables[`table-${id}`].columns,
        bDestroy: true,
    });

    let modules_length = document.querySelector(`#table-${id}_length`),
        select_length = document.querySelector(`#${id} .dataTables_length select`),
        label_length = document.querySelector(`#${id} .dataTables_length label`),
        reload_button = document.createElement("button"),
        reload_icon = document.createElement("i");

    reload_button.classList.add("btn", "btn-primary", "btn-icon", "btn-shadow", "btn-sm");
    reload_button.setAttribute("onclick", `reload_datatable("${id}")`);
    reload_icon.classList.add("fa", "fa-rotate");
    select_length.classList.add("form-select", "mx-2");
    label_length.classList.add("d-flex", "flex-row", "align-items-center");

    reload_button.appendChild(reload_icon);
    modules_length.appendChild(reload_button);
}