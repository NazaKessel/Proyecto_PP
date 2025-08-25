exports.success = function (req, res, mensaje, status){
    const statusCode = status || 200;
    const mensajeDef = mensaje || '';
    res.status(statusCode).send({ //respuesta estandar
        error: false,
        status: statusCode,
        body: mensajeDef
     });
}

//mensaje d error
exports.error = function (req, res, mensaje, status){
    const statusCode = status || 500;
    const mensajeError = mensaje || 'Error Interno';
    res.status(statusCode).send({
        error: true,
        status: statusCode,
        body: mensajeError
     });
}
