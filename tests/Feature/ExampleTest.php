<?php

test('a rota / redireciona para /carteirinhas', function () {
    $response = $this->get('/');
    $response->assertRedirect('/carteirinhas');
});

test('a rota /carteirinhas retorna 200', function () {
    $response = $this->get('/carteirinhas');
    $response->assertSuccessful();
});
