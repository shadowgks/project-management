// NOTE - Events
document.addEventListener('loadingVisible', function (e) {
    let data = e.detail;
    // editClassBody("page-loading", data);
    // editClassBody("overflow-hidden", data);
    loadingVisibility(data);
});

document.addEventListener('showSlideAlert', function (e) {
    let data = e.detail;
    showSlideAlert(data);
});

document.addEventListener('showAlert', function (e) {
    let data = e.detail;
    showAlert(data);
});

document.addEventListener('hideAlert', function (e) {
    hideAlert();
});

document.addEventListener('testEvent', function (e) {
    let data = e.detail;
    console.log(data);
});

document.addEventListener('reloadTable', function (e) {
    let data = e.detail,
        type_of_data = typeof data;

    if ((type_of_data == "object" && Object.keys(data).length > 0) || type_of_data == "string")
        reload_datatable(data);
    else
        console.error("Data of reload table is null!");
});

document.addEventListener('reloadSelect', function (e) {
    initSelect2();
});

document.addEventListener('reloadJoinFile', function (e) {
    let data = e.detail;
    importar_event(null, `upload-${data}`);
});

document.addEventListener('setChatConversation', function (e) {
    let data = e.detail;
    base_data.chat_conversation_id = data.chat_conversation_id;
});

$(document).ready(function () {
    initSelect2();
    getUnreadNotifications();
    init_custom_attibute();
    getMessages();
});