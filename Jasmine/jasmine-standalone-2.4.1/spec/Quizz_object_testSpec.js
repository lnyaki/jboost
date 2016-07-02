describe('[Quizz] **** Test suite for the initialization of the quizz object',function(){
	var quizz
	var fixture
	
	//set the default path for the fixture
	jasmine.getFixtures().fixturesPath = 'spec/fixture'
	
	//we initialize the quizz object
	beforeEach(function(){
		quizz = new Quizz()
				
		//loadFixtures('quizz_fixture.html')		
	})
	
	
	//Make sure that the quizz variables are initialized as expected
	it('Initialization of the quizz variables',function(){
		quizz.initialize()
		console.log("The quizz")
		console.log(quizz)
		expect(quizz.item_index).toBe(0)
		expect(quizz.points).toBe(0)
		expect(quizz.input_method).toBe('')
		expect(quizz.answer_quantity).toBe(0)
		expect(quizz.response_time).toBe(3)
		expect(quizz.list_name).toBe('')
	})
	
	//Need to make the fixtures work for this one (test the 'initialize options' method)
	it('Initialization of quizz options')
	
	xit('Loading of initial list of items',function(){
		//initialize list name
		var list = 'Hiragana'
		//load list elements
		expect(quizz.load_items(list)).not.toThrowError()
	})
})

//Fixtures
describe('Test suite for the initialization of the quizz page(html)',function(){

})


describe('Test suite for the reset of the quizz',function(){})

describe('Test suite for the validation of answers, calculation of quizz points and statistics',function(){})
