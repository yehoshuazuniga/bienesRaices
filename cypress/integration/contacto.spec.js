/// <reference types="cypress" />

describe('Prueba delm formularo de contacto', () => {
    it('Prueba la pagina de contacto y el envio de mails', () => {
        cy.visit('/contacto');

        cy.get('[data-cy= "heading-contacto"]').should('exist');
        cy.get('[data-cy= "heading-contacto"]').invoke('text').should('equal', 'Contacto');
        cy.get('[data-cy= "heading-contacto"]').invoke('text').should('not.equal', 'Formulario de contacto');


        cy.get('[data-cy= "heading-formulario"]').should('exist');
        cy.get('[data-cy= "heading-formulario"]').invoke('text').should('equal', 'Llene el formulario de Contacto');
        cy.get('[data-cy= "heading-formulario"]').invoke('text').should('not.equal', 'Llene el formulario de contacto');
   
        cy.get('[data-cy="formulario-contacto"]').invoke('text').should('not.equal', 'Llene el formulario de contacto');
   
    });

    it('Prueba de llenado de formulario', () => {
        cy.get('[data-cy="input-nombre"]').should('exist');
        cy.get('[data-cy="input-nombre"]').type('Yehoshua');
        cy.get('[data-cy="input-mensaje"]').type('quiero una casa');
        cy.get('[data-cy="input-opciones"]').select('Compra');
        cy.get('[data-cy="input-precio"]').type('15000');
        cy.get('[data-cy="forma-contacto"]').eq(1).check();
        cy.get('[data-cy="input-email"]').type('email@email.com')


        cy.wait(3000);

        cy.get('[data-cy="forma-contacto"]').eq(0).check();//este es el telefono
        cy.get('[data-cy="input-telefono" ]').type('123456456');
        cy.get('[data-cy="input-fecha" ]').type('2022-09-01');
        cy.get('[data-cy="input-hora" ]').type('15:00');

        cy.get('[data-cy="formulario-contacto"]').submit();
        cy.get('[data-cy="envio-formulario"]').should('exist');
        cy.get('[data-cy="envio-formulario"]').invoke('text').should('equal', 'Mensaje enviado');
        cy.get('[data-cy="envio-formulario"]').should('have.class', 'alerta').and('have.class', 'exito').and('not.have.class', 'erro');
    });
});