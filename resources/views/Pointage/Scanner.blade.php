@extends($role ? 'navbar' : 'Pointage.navbar')
    @section('content')
        <!-- HTML/CSS -->
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center" style="height: 100vh;">
                <div class="card text-center mb-3" style="width: 30rem;">
                    <div class="card-body">
                        <div style="text-align: center;"><h1>Veuillez scanner ici svp !</h1></div>
                        <div id="message-container" class="alert-success text-center font-weight-bold"></div>
                        <div style="display: flex; justify-content: center;">
                            <div id="my-qr-reader" style="width: 500px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bibliothèque JS -->
        <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <!--JAVA SCRIPT-->
        <script>
            //Fonction de vérification de la disponibilité du DOM
            function domReady(fn){
                if(document.readyState === "complete" || document.readyState === "interactive"){
                    setTimeout(fn, 1);
                } else {
                    document.addEventListener("DOMContentLoaded", fn);
                }
            }

            // Ajoute le token CSRF à chaque requête AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //Fonction du DOM
            domReady(function (){
                var myqr = document.querySelector(".my-qr-result");
                var lastResult, countResults = 0;

                //Réusite du scan
                function onScanSuccess(decodeText, decodeResult) {
                    if (decodeText !== lastResult) {
                        countResults++;
                        lastResult = decodeText;
                        sendScanData(decodeText);

                        // Attendre 1 seconde avant de lancer le prochain scan
                        setTimeout(startScan, 1000);
                    }
                }

                //Fonction d'envoie de données vers le back
                function sendScanData(qrCode) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('recupQrcode') }}",
                        data: { qrCode: qrCode },
                        success: function (response) {
                            if (response.success || !response.success){
                                var message = response.message;
                                var contenuMessage = $('#message-container');
                                contenuMessage.empty();
                                contenuMessage.append('<p>' + message + '<p>');
                            }
                            console.log("Scan réussi !");
                        },
                        error: function (xhr, status, error) {
                            console.error("Erreur lors de l'envoi du scan au serveur :", error);
                            console.log("Réponse du serveur :", xhr.responseText);
                        }
                    });
                }

                //Fonction de démarrage du scan
                function startScan() {
                    if (htmlScanner && typeof htmlScanner.start === 'function') {
                        htmlScanner.start();
                    }
                }

                var htmlScanner = new Html5QrcodeScanner(
                    "my-qr-reader",
                    { framesPerSecond: 10, qrbox: 250 }
                );
                htmlScanner.render(onScanSuccess);
            });
        </script>
    @endsection
