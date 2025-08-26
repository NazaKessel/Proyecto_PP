exports.success = function (req, res, mensaje = '', status = 200){
    res.status(status).send({ //respuesta estandar
        error: false,
        status: status,
        body: mensaje
     });
}

//mensaje d error
exports.error = function (req, res, mensaje = 'Error Interno', status = 500){
    res.status(status).send({
        error: true,
        status: status,
        body: mensaje
     });
}
