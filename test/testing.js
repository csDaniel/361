//Bryant and Lucy's work starting on Mocha testing. We are meeting again
//tomorrow to continue work

//This still needs some work  but we wanted to start on mocha and unit testing
// Once we got the correct  syntax we an get a lot of unit tests done quickly

//This tests, but not fully working yet, the the first name in the create
//account to make sure that it is a string

var chai = require('chai');
var expect = require('chai').expect;
var firstname = require('./Index');

describe('Is filled out', function() {
  it('Should always have a value', function() {
    var username = 'Bob1';
    var password = 'password';
    var FN = 'Bob';
    var lastname = 'Smith';
    var address = '2501 SW Jefferson Way';
    var city = 'Corvallis';
    var state = 'Oregon';
    var Firstname = firstname.bindButtons(FN);
    expect(Firstname).to.be.a('string');

  });

});
