<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test View</title>

    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        window.OneSignal = window.OneSignal || [];

        OneSignal.push(function() {
            OneSignal.init({
                appId: "{{ env('ONE_SIGNAL_APP_ID') }}",
            });

            // let externalUserId = "123456789";
            // OneSignal.setExternalUserId(externalUserId);
            // OneSignal.getExternalUserId().then(function(externalUserId) {
            //     console.log("externalUserId: ", externalUserId);
            // });
        });

        // OneSignal.getIds(function(ids) {
        //     alert("player id: " + ids.userId);
        // });
    </script>
</head>

<body>

</body>

</html>
