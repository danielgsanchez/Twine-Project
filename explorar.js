// Función para cargar y mostrar un perfil aleatorio
function loadRandomProfile() {
    $.ajax({
        url: 'controllers/get_random_profile.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Actualizar la información del perfil en la página
            if (response.success) {
                var profile = response.profile;
                $('.card-img-top').attr('src', profile.link);
                $('.card-title').text(profile.first_name);
                $('.card-text.gender').text(profile.gender_id);
                $('.card-text.description').text(profile.description);
            } else {
                // Mostrar un mensaje de error si no se encontró ningún perfil
                $('.card').html('<p>No se encontraron perfiles disponibles.</p>');
            }
        },
        error: function() {
            // Mostrar un mensaje de error
            $('.card').html('<p>Error en la solicitud AJAX.</p>');
        }
    });
}

// Función para manejar la acción de coincidencia con AJAX
function matchProfile(profileId) {
    $.ajax({
        url: 'controllers/match.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'match',
            profile_id: profileId
        },
        success: function(response) {
            if (response.success) {
                // Mostrar un mensaje de éxito
                alert('¡Has coincidido con el perfil!');
            } else {
                // Mostrar un mensaje de error
                alert('Error al realizar la coincidencia.');
            }
            loadRandomProfile();
        },
        error: function() {
            // Mostrar un mensaje de error
            alert('Error en la solicitud AJAX.');
        }
    });
}

// Función para manejar la acción de rechazar con AJAX
function rejectProfile(profileId) {
    $.ajax({
        url: 'controllers/reject.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'reject',
            profile_id: profileId
        },
        success: function(response) {
            if (response.success) {
                // Mostrar un mensaje de éxito
                alert('Has rechazado el perfil.');
            } else {
                // Mostrar un mensaje de error
                alert('Error al rechazar el perfil.');
            }
            loadRandomProfile();
        },
        error: function() {
            // Mostrar un mensaje de error
            alert('Error en la solicitud AJAX.');
        }
    });
}
