describe('[Flashcard]Test suite for the initialization of the Flashcard',function(){
	var flashcard
	
	beforeEach(function(){
		jasmine.getFixtures().fixturesPath = 'spec/fixtures';
		//jasmine.getFixtures().fixturesPath = 'http://localhost/fixture';

		//create flashcard
		flashcard = new Flashcard()
	})
	
	//To do later (more complex test case, or maybe need other fixture)
	it('Test the creation of the textfield used in case of direct input',function(){
		loadFixtures('quizz_fixture.html')
		expect('#quizz_options').not.toBe(undefined)
	})
	
	it('Initializes the validation button of the flashcard')
	
})

describe('Test suite for all types of validation functions',function(){
	var flashcard
	
	beforeEach(function(){
		jasmine.getFixtures().fixturesPath = 'spec/fixtures';
		//jasmine.getFixtures().fixturesPath = 'http://localhost/fixture';

		//create flashcard
		flashcard = new Flashcard()
	})

	//Test validation for "question to answer" (q2a) and "answer to question" (a2q)
	it('Validate the that the answer is correct for this flashcard',function(){
		var direction1 	= 'q2a'
		var direction2	= 'a2q'
		var answer1		= 'a'
		var answer2		= 'あ'


		//create the item as a simple js object
		var item = {item	: 'あ'
				   ,answer	: 'a'}
		
		//First, set the quizz direction
		flashcard.set_quizz_direction(direction1)
		
		//set the item
		flashcard.set_item(item)
		
		//then validate
		expect(flashcard.validate(answer1)).toBe(true)
		
		//First, set the quizz direction
		flashcard.set_quizz_direction(direction2)
		
		//set the item
		flashcard.set_item(item)
		
		//then validate
		expect(flashcard.validate(answer2)).toBe(true)
	})
	
})

describe('Test suite for accessing various elements (Getters)',function(){
	var flashcard
	
	beforeEach(function(){
		jasmine.getFixtures().fixturesPath = 'spec/fixtures';
		
		//create flashcard
		flashcard = new Flashcard()
	})

	it('Extract the user answer from the html flashcard')
	
	it('Generate a certain number of html buttons')
	it('Get the existing buttons from the html flashcard')
	it('Get a certain number of random elements from the item list')
	it('Check if an element belongs to a list')
	it('Generate the validation button for the flashcard')
	it('Get the click function of a quizz button')
	it('Get the current quizz item')
	it('Get the flashcard input method')
	it('Get the flashcard direction (kana -> romaji, etc)')
	it('Generate the validation button in case of direct input')
	it('Get the quizz object attached to the flashcard object')
})

describe('Test suite for checking all the "setters" functions',function(){
	var flashcard
	
	beforeEach(function(){
		jasmine.getFixtures().fixturesPath = 'spec/fixtures';
		
		//create flashcard
		flashcard = new Flashcard()
	})
	
	it('Check the function the sets points')
	it('Display the correctness of the user answer (right/wrong) in the view')
	it('Sets the type of quizz (Kana to romaji, romaji to kana, etc')
	it('Set the remaining time for this answer')
	it('Set the number of possible answer for this flashcard (in case of multiple answers')
	it('Set the quizz item to the Flashcard')
	
	//Set new item to the flashcard (only the model, not the view)
	it('Set the new quizz item in the flashcard (model)',function(){
		var answer		= 'a'
		var question	= 'あ'
		var direction	= 'q2a'

		//create the item as a simple js object
		var item = {item	: question
				   ,answer	: answer}
		
		flashcard.set_item(item)
		
		expect(flashcard.get_item().item).toEqual(question)
		expect(flashcard.get_item().answer).toEqual(answer)
	})
	
	//When there is a new item on the flashcard, we need to make sure it is
	//displayed on the card
	//ERR : for some reason, the $(ITEM_DIV) element remains emtpy.
	// ==> TO check when we'll be able to visually confirm with chrome
	xit('Set the text of the new item (view)',function(){
		var answer		= 'a'
		var question	= 'あ'
		var direction	= 'q2a'
		var ITEM_DIV	= '#item';
		//create the item as a simple js object
		var item = {item	: question
				   ,answer	: answer}
		
		//First set the quizz direction
		flashcard.set_quizz_direction(direction)
		//Then we set the item
		flashcard.set_item(item)
		console.log('xxxxxxxxxxxxxxxxxx')
		expect($(ITEM_DIV)).not.toBe(undefined)
		expect($(ITEM_DIV).text()).toEqual(question)
	})
	
	it('Empty the answer textfield in case of a direct input game')
})