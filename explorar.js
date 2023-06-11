// Función para cargar y mostrar un perfil aleatorio
function loadRandomProfile() {
  $.ajax({
    url: "controllers/get_random_profile.php",
    type: "GET",
    dataType: "json",
    success: function (response) {
      // Actualizar la información del perfil en la página
      if (response.success) {
        var profile = response.profile;
        $(".card-img-top").attr("src", profile.link);
        $("#name").text(profile.first_name + " " + profile.last_name);
        $("#gender").text(profile.gender_name);
        $("#description").text(profile.description);
        $("#hobbies").text(profile.hobbies);

        // Actualizar las ID de los botones
        $(".btn.btn-primary").attr("data-profile-id", profile.id);
        $(".btn.btn-danger").attr("data-profile-id", profile.id);
      } else {
        // Mostrar un mensaje de error si no se encontró ningún perfil
        $(".card").html("<p>No se encontraron perfiles disponibles.</p>");
      }
    },
    error: function () {
      // Mostrar un mensaje de error
      $(".card").html("<p>Error en la solicitud AJAX.</p>");
    },
  });
}

// Función para manejar la acción de coincidencia con AJAX
function matchProfile(profileId) {
  var profileId = $("#mBtn").attr("data-profile-id");
  $.ajax({
    url: "controllers/match.php",
    type: "POST",
    dataType: "json",
    data: {
      action: "match",
      profile_id: profileId,
    },
    success: function (response) {
      if (response.success) {
        // Mostrar un mensaje de éxito utilizando una notificación emergente
        toastr.success("¡Has coincidido con el perfil!", "¡Enlazado!", {
          closeButton: true,
          progressBar: true,
          positionClass: "toast-top-left",
          timeOut: 3000,
          extendedTimeOut: 2000,
          showDuration: 300,
          hideDuration: 300,
          showEasing: "swing",
          hideEasing: "linear",
          showMethod: "fadeIn",
          hideMethod: "fadeOut",
          // Personalizar el estilo del mensaje de éxito
          tapToDismiss: false,
          onclick: null,
          closeHtml: '<button><i class="fa fa-times"></i></button>',
          progressBarColor: "#00cc66", // Color verde
          toastClass: "toast success match",
        });
      } else {
        // Mostrar un mensaje de error utilizando una notificación emergente
        toastr.error("Error al rechazar el perfil.", "Error", {
          closeButton: true,
          progressBar: true,
          positionClass: "toast-top-right",
          timeOut: 3000,
          extendedTimeOut: 2000,
          // Personalizar el estilo del mensaje de error
          tapToDismiss: false,
          onclick: null,
          closeHtml: '<button><i class="fa fa-times"></i></button>',
          progressBarColor: "#ff0000", // Color rojo
          toastClass: "toast error",
          toastId: "error-toast",
        });
      }
      loadRandomProfile();
    },
    error: function () {
      // Mostrar un mensaje de error utilizando una notificación emergente
      toastr.error("Error en la solicitud AJAX.");
    },
  });
}

// Función para manejar la acción de rechazar con AJAX
function rejectProfile(profileId) {
  var profileId = $("#rBtn").attr("data-profile-id");
  $.ajax({
    url: "controllers/reject.php",
    type: "POST",
    dataType: "json",
    data: {
      action: "reject",
      profile_id: profileId,
    },
    success: function (response) {
      if (response.success) {
        toastr.success("Has pasado del perfil.", "Pasar", {
          closeButton: true,
          progressBar: true,
          positionClass: "toast-top-right",
          timeOut: 3000,
          extendedTimeOut: 2000,
          // Personalizar el estilo del mensaje de éxito
          tapToDismiss: false,
          onclick: null,
          closeHtml: '<button><i class="fa fa-times"></i></button>',
          progressBarColor: "#00cc66",
          toastClass: "toast success reject",
          toastId: "success-toast",
        });
      } else {
        // Mostrar un mensaje de error utilizando una notificación emergente
        toastr.error("Error al rechazar el perfil.", "Error", {
          closeButton: true,
          progressBar: true,
          positionClass: "toast-top-right",
          timeOut: 3000,
          extendedTimeOut: 2000,
          // Personalizar el estilo del mensaje de error
          tapToDismiss: false,
          onclick: null,
          closeHtml: '<button><i class="fa fa-times"></i></button>',
          progressBarColor: "#ff0000", // Color rojo
          toastClass: "toast error",
          toastId: "error-toast",
        });
      }
      loadRandomProfile();
    },
    error: function () {
      // Mostrar un mensaje de error utilizando una notificación emergente
      toastr.error("Error en la solicitud AJAX.");
    },
  });
}
