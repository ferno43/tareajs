<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

// get all todos
    $app->get('/query1', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT pelicula FROM pelicula");
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });

    // Retrieve todo with id
    $app->get('/query2/[{id}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT pelicula, genero FROM `pelicula` INNER JOIN pelicula_genero ON
pelicula.id=pelicula_genero.idpelicula INNER JOIN genero ON pelicula_genero.idgenero=genero.id WHERE pelicula.id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $todos = $sth->fetchObject();
        return $this->response->withJson($todos);
    });

    $app->get('/query3/[{id}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT pelicula.pelicula, rol.rol, persona.nombre, persona.apellido FROM persona INNER JOIN pelicula_persona ON persona.id=pelicula_persona.idpersona
INNER JOIN pelicula ON pelicula.id=pelicula_persona.idpelicula INNER JOIN rol ON rol.id=pelicula_persona.idrol WHERE persona.id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $todos = $sth->fetchObject();
        return $this->response->withJson($todos);
    });

    $app->get('/query4/[{id}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT genero, pelicula FROM pelicula INNER JOIN pelicula_genero ON pelicula.id=pelicula_genero.idpelicula INNER JOIN
genero ON pelicula_genero.idgenero=genero.id WHERE genero.id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $todos = $sth->fetchObject();
        return $this->response->withJson($todos);
    });

    $app->get('/query5/[{id}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT pelicula, resena FROM resena INNER JOIN pelicula ON resena.idpelicula=pelicula.id WHERE pelicula.id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $todos = $sth->fetchObject();
        return $this->response->withJson($todos);
    });

    // Add a new todo
    $app->post('/query6', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO persona (idp, nombre, apellido, sexo, fnac, idpais) VALUES (:task)";
         $sth = $this->db->prepare($sql);
        $sth->bindParam("task", $input['34,fer,lopez,H,1995-08-19,1']);
        $sth->execute();
        $input['id'] = $this->db->lastInsertId();
        return $this->response->withJson($input);
    });

    // DELETE a todo with given id
    $app->delete('/query7/[{id}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("DELETE FROM persona WHERE id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });

    // Update todo with given id
    $app->put('/query8/[{id}]', function ($request, $response, $args) {
        $input = $request->getParsedBody();
        $sql = "UPDATE persona SET apellido=:task where id=:id";
         $sth = $this->db->prepare($sql);
        $sth->bindParam("id", $args['id']);
        $sth->bindParam("task", $input["zapatas"]);
        $sth->execute();
        $input['id'] = $args['id'];
        return $this->response->withJson($input);
    });
