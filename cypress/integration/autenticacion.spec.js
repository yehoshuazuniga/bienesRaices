///<reference types="cypress" />
describe('Probar la Autenticacion', () => {
    it('Probar la Autenticacion en /login', ()=>{  
        cy.visit('/login');
        cy.get('[data-cy="heading-login"]').should('exist');
        cy.get('[data-cy="heading-login"]').should('have.text', 'Iniciar Sesón');

        cy.get('[data-cy="formulario-login"]').should('exist');

        //ambos campo son obligatorios
        cy.get('[data-cy="formulario-login"]').submit();
        cy.get('[data-cy="alerta-login" ]').should('exist');
      
        cy.get('[data-cy="alerta-login" ]').eq(0).should('have.class', 'error');
        cy.get('[data-cy="alerta-login" ]').eq(0).should('have.text', 'Email es obligatorio');
      
        cy.get('[data-cy="alerta-login" ]').eq(1).should('have.class', 'error');
        cy.get('[data-cy="alerta-login" ]').eq(1).should('have.text', 'Password es obligatorio');
        //el usuario existe


        //verificar el password
    });
});