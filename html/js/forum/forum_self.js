"use strict";

/////////////// Node ////////////////
function Node(id, value, creator) {
    this.id = id;
    this.data = value;
	this.creator = creator;
    this.votes = 0;
    this.next = null;
    this.upvoters = null;
    this.downvoters = null;
}

Node.prototype.initVoters = function () {
    this.upvoters = new DoublyList();
    this.downvoters = new DoublyList();
};

function Question(id, value, creator) {
    Node.call(this, id, value, creator);
    this.initVoters();
    this.answers = new DoublyList();
}

Question.prototype.addNewAnswer = function(node) {
    this.answers.addToTail(node);
};

Question.prototype = new Node();

function Answer(id, value, creator) {
    Node.call(this, id, value, creator);
    this.initVoters();
}

Answer.prototype = new Node();


/////////////// List ////////////////

function DoublyList() {
    this._length = 0;
    this._id_counter = 0;
    this.head = null;
    this.tail = null;
    this.file = new Node(0, 0, null);
}

DoublyList.prototype.addToTail = function(node) {
    if (this._length) {
        this.tail.next = node;
        this.tail = node;
    } else {
        this.head = node;
        this.tail = node;
    }

    this._id_counter++;
    this._length++;

    console.log("Add: length = " + this._length);
    console.log("add new node to upvoters. username = " + node.data);
    return node;
};

DoublyList.prototype.add = function(node) {

    var current = null;

    if(this._length === 0) {
        this.addToTail(node);
        return;
    }

    current = this.head;

    if(node.votes > current.votes) {
        node.next = current;
        this.head = node;

        this._id_counter++;
        this._length++;

        return;
    }

    var beforeNode = null;
    while (current) {
        beforeNode = current;
        if (node.votes > current.votes) {
            node.next = current;
            beforeNode.next = node;

            this._id_counter++;
            this._length++;

            return;
        }

        current = current.next;
    }
};

DoublyList.prototype.searchNodeById = function(id) {
    var currentNode = this.head,
        id_counter = this._id_counter,
        count = 1,
        message = {failure: 'Could not find node in list'};

        console.log("search: length = " + this._length);
    // 1st use-case: an invalid position
    if (this._length === 0 || id < 0) {
        console.log(message.failure);
        return null;
    }

    // 2nd use-case: a valid position
    while (currentNode) {
        console.log("serching: id = " + id + " currentNode.id = " + currentNode.id);
        if (id === currentNode.id) {
            console.log("returning currentNode");
            return currentNode;
        }
        currentNode = currentNode.next;
    }

    return currentNode;
};

DoublyList.prototype.remove = function(node) {
    var currentNode = this.head,
        length = this._length,
        count = 1,
        message = {failure: 'Failure: non-existent node in this list.'},
        beforeNodeToDelete = null,
        afterNodeToDelete = null,
        nodeToDelete = null,
        deletedNode = null;

    console.log("remove node " + node.id);
    // 1st use-case: an invalid position
    if (length === 0 || node.id < 0) {
        console.log(message.failure);
        return null;
    }

    // 2nd use-case: the first node is removed
    if (node.id === this.head.id) {
        // 2nd use-case: there is no second node
        if(node.id === this.tail.id) {
            this.tail = this.head;
        } else if (this.head.next !== null) {
			if (this.head.next.id === this.tail.id) { //there are only two nodes in the list
            	this.tail = currentNode.next;
        	}
		}
        this.head = currentNode.next;
        deletedNode = node;

    } else {
        beforeNodeToDelete = currentNode;
        currentNode = currentNode.next;

        while (currentNode) {
            if (currentNode.id === node.id) {
                nodeToDelete = currentNode;
                afterNodeToDelete = currentNode.next;

                beforeNodeToDelete.next = afterNodeToDelete;
                deletedNode = nodeToDelete;
                nodeToDelete = null;

                break;
            }

            beforeNodeToDelete = currentNode;
            currentNode = currentNode.next;
        }
    }

    this._length--;

    console.log("Successfully removed node id = " + deletedNode.id);
    return deletedNode;
};

//////////// Points functions //////////////////

function addPointAjax(username) {
    console.log("sending Ajax");
      $.ajax({
           type: "POST",
           url: '../../../../../php/upload_form/ajax.php',
           data:{action:'addPointToUser', ADDED_BY_EMAIL: username},
           success:function(html) {
             console.log(html);
           },
           error: function(xhr,textStatus,err) {
            console.log("Error sending ajax");
            console.log(xhr + textStatus + err);
           }
      });
 }
 
function removePointAjax(username) {
    console.log("sending Ajax");
      $.ajax({
           type: "POST",
           url: '../../../../../php/upload_form/ajax.php',
           data:{action:'removePointToUser', ADDED_BY_EMAIL: username},
           success:function(html) {
             console.log(html);
           },
           error: function(xhr,textStatus,err) {
            console.log("Error sending ajax");
            console.log(xhr + textStatus + err);
           }
      });
 }
 
////////////// voting ////////////
function upvoteAjax() {
    console.log("sending Ajax");
      $.ajax({
           type: "POST",
           url: '../../../../../php/upload_form/ajax.php',
           data:{action:'upvoteFile', courseNum: courseNum, type: type, fileId: fileId,
		   		ADDED_BY_EMAIL: ADDED_BY_EMAIL},
           success:function(html) {
             console.log(html);
           },
           error: function(xhr,textStatus,err) {
            console.log("Error sending ajax");
            console.log(xhr + textStatus + err);
           }
      });
 }
 
 function downvoteAjax() {
    console.log("sending Ajax");
      $.ajax({
           type: "POST",
           url: '../../../../../php/upload_form/ajax.php',
           data:{action:'downvoteFile', courseNum: courseNum, type: type, fileId: fileId,
		   		ADDED_BY_EMAIL: ADDED_BY_EMAIL},
           success:function(html) {
             console.log(html);
           },
           error: function(xhr,textStatus,err) {
            console.log("Error sending ajax");
            console.log(xhr + textStatus + err);
           }
      });
 }

Node.prototype.upvote = function (userId, userName, ADDED_BY_EMAIL) {

    var node = this.upvoters.searchNodeById(userId);
    if (node === null) {
        node = new Node(userId, userName, userName);
        this.votes++;
		if (this.creator !== null) { // If creator == null this is a file and 
									// the uploader shouldn't be credited twice
			addPointAjax(this.creator); //Add point to node creator
		}
        upvoteAjax();
        if (this.downvoters.remove(node) === null) {
            this.upvoters.addToTail(node);
			addPointAjax(userName); // Add point to voter (we insert new node to list)
			addPointAjax(ADDED_BY_EMAIL); //Add point to File uploader
        } else {
			removePointAjax(userName); // Remove point to voter (user already voted on this,
										// stop users from voting up and down to get points);
			addPointAjax(ADDED_BY_EMAIL); //Add point to File uploader
		}
    } else {
        alert("You already upvoted this");
    }

    return;
};

Node.prototype.downvote = function (userId, userName, ADDED_BY_EMAIL) {

    var node = this.downvoters.searchNodeById(userId);
    if (node === null) {
        node = new Node(userId, userName, userName);
        this.votes--;
		if (this.creator !== null) { // If creator == null this is a file and 
									// the uploader shouldn't be credited twice
			removePointAjax(this.creator); //Remove point to node creator
		}
        downvoteAjax();
        if (this.upvoters.remove(node) === null) {
            this.downvoters.addToTail(node);
			addPointAjax(userName); // Add point to voter (For voting)
			removePointAjax(ADDED_BY_EMAIL); //Remove point to File uploader
        } else {
			removePointAjax(userName); // Remove point to voter (user already voted on this,
										// stop users from voting up and down to get points);
			removePointAjax(ADDED_BY_EMAIL); //remove point to File uploader
		}
    } else {
        alert("You already downvoted this");
    }

    return;
};

DoublyList.prototype.upvote = function (nodeId, userId, userName, ADDED_BY_EMAIL) {
    var node = this.searchNodeById(nodeId);
	if (node === null ) {
		console.log("Error: could not find node to upvote");
		return;
	}
    node.upvote(userId, userName, ADDED_BY_EMAIL);
    this.remove(node);
    this.add(node);
};

DoublyList.prototype.downvote = function (nodeId, userId, userName, ADDED_BY_EMAIL) {
    var node = this.searchNodeById(nodeId);
	if (node === null ) {
		console.log("Error: could not find node to downvote");
		return;
	}
    node.downvote(userId, userName, ADDED_BY_EMAIL);
    this.remove(node);
    this.add(node);
};
 
//////////// printing functions ////////////////
var questions = new DoublyList();

DoublyList.prototype.printFileVotes = function () {

    var myNode = document.getElementById("fileVotes");

    while (myNode.firstChild) {
        myNode.removeChild(myNode.firstChild);
    }
    
    var fileVotesDiv = document.createElement('div');

    fileVotesDiv.className = 'fileVotes';

    fileVotesDiv.innerHTML =
        questions.file.votes;

    fileVotesDiv.style.fontSize = "36px";
    fileVotesDiv.style.color = "#FCFCFC";

    document.getElementById('fileVotes').appendChild(fileVotesDiv);
};

DoublyList.prototype.printToConsole  = function (){
    var current = this.head;
    while(current) {
        console.log(" id = " + current.id + ", data = " + current.data);
        current = current.next;
    }
};

Answer.prototype.printAnswer = function(questionId) {
    var answerDiv = document.createElement('div');

    answerDiv.className = 'answer';

    answerDiv.innerHTML =
        '<div class="answer" data-color="gray">\n' +
        '\t\t\t<div class="votes">\n' +
        '\t\t\t\t<div class="upvote" onclick="upvoteAnswer(' + 
        questionId +
        ',' + this.id +
        ',' + userId +
        ', \'' + userName +'\'' +
		', \'' + ADDED_BY_EMAIL +'\')">\n' +
        '</div>\n' +
        '\t\t\t\t<div class="number-of-votes">' + this.votes + '\n' +
        '                </div>\n' +
        '\t\t\t\t<div class="downvote" onclick="downvoteAnswer(' +
        questionId +
        ',' + this.id +
        ',' + userId +
        ', \'' + userName +'\'' +
		', \'' + ADDED_BY_EMAIL +'\')">\n' +
        '</div>\n' +
        '\t\t\t</div>\n' +
        '\t\t\t<div class="question-and-answer">\n' +        '\t\t\t\t<p style="color: #000000; direction: rtl;">' + this.data + '</p>\n' +
        '\t\t\t\t<div style="text-align:center;">\n' +
        '\t\t\t\t</div>\n' +
        '\t\t\t</div>\n' +
        '\t\t</div>';


    return answerDiv;
};

Question.prototype.printAllAnswers = function() {

    var current = this.answers.head;

    var answers = document.createElement('div');

    answers.id = this.id;

    while(current) {
        answers.appendChild(current.printAnswer(this.id));
        current = current.next;
    }

    return answers;
};

Question.prototype.printQuestion = function() {
    var questDiv = document.createElement('div');

    questDiv.className = 'question';

    questDiv.innerHTML =
        '<div class="question" data-color="gray">\n' +
        '\t\t\t<div class="votes">\n' +
        '\t\t\t\t<div class="upvote" onclick="upvoteQuestion(' +
        this.id +
        ',' + userId +
        ', \'' + userName +'\'' +
		', \'' + ADDED_BY_EMAIL +'\')">\n' +
        '</div>\n' +
        '\t\t\t\t<div class="number-of-votes">' + this.votes + '\n' +
        '                </div>\n' +
        '\t\t\t\t<div class="downvote" onclick="downvoteQuestion(' +
        this.id +
        ',' + userId +
        ', \'' + userName +'\'' +
		', \'' + ADDED_BY_EMAIL +'\')">\n' +
'</div>\n' +
        '\t\t\t</div>\n' +
        '\t\t\t<div class="question-and-answer">\n' +
        '\t\t\t\t<p style="color: #000000; direction: rtl;">' + this.data + '</p>\n' +
        '\t\t\t\t<div style="text-align:center;">\n' +
        '\t\t\t\t\t<textarea id="textArea_' + this.id + '" type="answer" placeholder="הגב" style="width:60%;"></textarea>\n' +
        '\t\t\t\t\t<br>\n' +
        '\t\t\t\t\t<input type="submit" class="button2" name="action" id="upload_submit" value="answer" onClick="answerQuestion('+ this.id + ', ' + userName + ')"/>\n' +
        '\t\t\t\t</div>\n' +
        '\t\t\t</div>\n' +
        '\t\t</div>';

    var answers = this.printAllAnswers();

    questDiv.appendChild(answers);
    document.getElementById('questions').appendChild(questDiv);

    return questDiv;
};

DoublyList.prototype.printAllNodes = function() {

    var current = this.head;

    var myNode = document.getElementById("questions");

    while (myNode.firstChild) {
        myNode.removeChild(myNode.firstChild);
    }

    while(current) {
        current.printQuestion();
        current = current.next;
    }
    
    this.printFileVotes();
};


function QuestionsList() {
    // for future inheritance purposes
}

QuestionsList.prototype = new DoublyList();


//////////// In page functions ///////////

function askQuestion(userName) {
    var textArea = document.getElementById("questionText");
    questions.addToTail(new Question(questions._id_counter, textArea.value, userName));
    questions.printAllNodes();
    
    saveForum();
}

function answerQuestion(id, userName){
    var textArea = document.getElementById("textArea_" + id);
    var question = questions.searchNodeById(id);
    question.answers.addToTail(new Answer(question.answers._id_counter, textArea.value, userName));
    questions.printAllNodes();
    
    saveForum();
}

function upvoteQuestion(questionId, userId, userName, ADDED_BY_EMAIL) {
    questions.upvote(questionId, userId, userName, ADDED_BY_EMAIL);
    questions.printAllNodes();
    saveForum();
}

function downvoteQuestion(questionId, userId, userName, ADDED_BY_EMAIL) {
    questions.downvote(questionId, userId, userName, ADDED_BY_EMAIL);
    questions.printAllNodes();
    
    saveForum();
}

function upvoteAnswer(questionId, answerId, userId, userName, ADDED_BY_EMAIL) {
    var question = questions.searchNodeById(questionId);
    question.answers.upvote(answerId, userId, userName, ADDED_BY_EMAIL);
    questions.printAllNodes();
    
    saveForum();

}

function downvoteAnswer(questionId, answerId, userId, userName, ADDED_BY_EMAIL) {
    var question = questions.searchNodeById(questionId);
    question.answers.downvote(answerId, userId, userName, ADDED_BY_EMAIL);
    questions.printAllNodes();
    
    saveForum();
}

function upvoteFile(ADDED_BY_EMAIL){
    if (questions.file.upvoters === null) {
        questions.file.upvoters = new DoublyList();
    }
    
    if (questions.file.downvoters === null) {
        questions.file.downvoters = new DoublyList();
    }
    
    questions.file.upvote(userId, userName, ADDED_BY_EMAIL);
    questions.printFileVotes();
	    
    saveForum();
}

function downvoteFile(ADDED_BY_EMAIL) {
    if (questions.file.upvoters === null) {
        questions.file.upvoters = new DoublyList();
    }
    
    if (questions.file.downvoters === null) {
        questions.file.downvoters = new DoublyList();
    }

    questions.file.downvote(userId, userName, ADDED_BY_EMAIL);
    questions.printFileVotes();
	
    
    saveForum();
}

function getFileVotes() {
    if (questions)
        return questions.file.votes;

    return 0;
}

/////////// Parse functions /////////////

function parseVoter(jsonVoter) {
    if (jsonVoter === null) {
        return null;
    }

    var voter = new Node(jsonVoter.id, jsonVoter.data, jsonVoter.creator);
    if (jsonVoter.next !== null) {
        voter.next = parseVoter(jsonVoter.next);
    } else {
        voter.next = null;
    }

    return voter;
}

function parseVotersList(jsonVotersList) {
    if (jsonVotersList === null) {
        return null;
    }

    var votersList = new DoublyList();
    votersList._length = jsonVotersList._length;
    votersList._id_counter = jsonVotersList._id_counter;
    if(jsonVotersList.head !== null) {
        votersList.head = parseVoter(jsonVotersList.head);
    } else {
        votersList.head = null;
    }

    votersList.tail = jsonVotersList;

    return votersList;
}

function parseAnswer(jsonAnswer) {
    if (jsonAnswer === null) {
        return null;
    }

    var answer = new Answer(jsonAnswer.id, jsonAnswer.data, jsonAnswer.creator);
    answer.votes = jsonAnswer.votes;
    if (jsonAnswer.next !== null) {
        answer.next = parseAnswer(jsonAnswer.next);
    }

    if (jsonAnswer.upvoters !== null) {
        answer.upvoters = parseVotersList(jsonAnswer.upvoters);
    } else {
        answer.upvoters = new DoublyList();
    }

    if (jsonAnswer.downvoters !== null) {
        answer.downvoters = parseVotersList(jsonAnswer.downvoters);
    } else {
        answer.downvoters = new DoublyList();
    }

    return answer;
}

function parseAnswersList(jsonAnswersList) {
    if (jsonAnswersList === null) {
        return null;
    }

    var answersList = new DoublyList();
    answersList._length = jsonAnswersList._length;
    answersList._id_counter = jsonAnswersList._id_counter;
    answersList.head = parseAnswer(jsonAnswersList.head);
    answersList.tail = jsonAnswersList.tail;

    return answersList;
}

function parseQuestion(jsonQuestion, jsonAnswers) {

    if (jsonQuestion === null) {
        return null;
    }

    var question = new Question(jsonQuestion.id, jsonQuestion.data, jsonQuestion.creator);
    question.votes = jsonQuestion.votes;

    if (jsonQuestion.next !== null) {
        question.next = parseQuestion(jsonQuestion.next);
    }

    if (jsonQuestion.upvoters !== null) {
        console.log("parsing upvoters list");
        question.upvoters = parseVotersList(jsonQuestion.upvoters);
    } else {
        question.upvoters = new DoublyList();
    }

    if (jsonQuestion.downvoters !== null) {
        question.downvoters = parseVotersList(jsonQuestion.downvoters);
    } else {
        question.downvoters = new DoublyList();
    }

    question.answers = parseAnswersList(jsonQuestion.answers);

    return question;

}

function parseJson(json) {
    var tempQuestions = new DoublyList();
    // what if json is just {}?
    if (json === null) {
        return tempQuestions;
    }

    tempQuestions._id_counter = json._id_counter;
    tempQuestions._length = json._length;
    if (json.head !== null) {
        tempQuestions.head = parseQuestion(json.head);
    }
    tempQuestions.tail = json.tail;
    tempQuestions.file = parseAnswer(json.file); // file behaves like an answer. 

    return tempQuestions;
}

////////////// save and load functions - JSON ////////

function saveForum(){
    var myJson = JSON.stringify(questions);

    var loc = window.location.pathname;
    var dir = loc.substring(0, loc.lastIndexOf('/'));
    var path = "../.." + dir.toString();

    $.ajax({
        url     : '../../../../../php/savejson.php',
        method  : 'post',
        data    : {'myJson' : myJson, 'path' : path},
        success : function( response ) {
            console.log(response);
        },
        error: function(xhr,textStatus,err) {
            console.log("Forum not saved");
            console.log(xhr + textStatus + err);
        }
    });
}

function loadForum(){

    //var loc = window.location.pathname;
    //var dir = loc.substring(0, loc.lastIndexOf('/'));

    //var path = "../../../.." + dir.toString();

    $.ajax({
        type: 'GET',
        url: "forum.json",
        async: false,
        jsonpCallback: 'callback',
        contentType: "application/json",
        dataType: 'json',
        success: function(json) {
            var newQuestions = parseJson(json);
            questions = newQuestions;
        },
        error: function(xhr,textStatus,err) {
            console.log("No forum found");
            console.log(xhr + textStatus + err);
            questions = new DoublyList();
        }
    });
    
    questions.printAllNodes();
}