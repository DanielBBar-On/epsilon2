/////////////// Node ////////////////
function Node(id, value) {
    this.id = id;
    this.data = value;
    this.votes = 0;
    this.next = null;
}

function Question(id, value) {
    Node.call(this, id, value);
    this.answers = new DoublyList();
}

Question.prototype.addNewAnswer = function(node) {
    this.answers.addToTail(node);
}

Question.prototype = new Node();

function Answer(id, value) {
    Node.call(this, id, value);
    this.replies = new DoublyList();
}

Answer.prototype = new Node();

Answer.prototype.addNewReply = function(node) {
    this.replies.addToTail(node);
}

/////////////// List ////////////////

function DoublyList() {
    this._length = 0;
    this._id_counter = 0;
    this.head = null;
    this.tail = null;
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

    return node;
};

DoublyList.prototype.add = function(node) {

    var current = null;

    if(this._length == 0) {
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

    while (current) {
        if (node.votes > current.votes) {
            node.next = current;

            this._id_counter++;
            this._length++;

            return;
        }

        current = current.next;
    }
}

DoublyList.prototype.searchNodeById = function(id) {
    var currentNode = this.head,
        id_counter = this._id_counter,
        count = 1,
        message = {failure: 'Failure: non-existent node in this list.'};

    // 1st use-case: an invalid position
    if (length === 0 || id < 0 || id > id_counter) {
        throw new Error(message.failure);
    }

    // 2nd use-case: a valid position
    while (currentNode) {
        if (id == currentNode.id) {
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

    // 1st use-case: an invalid position
    if (length === 0 || node.id < 0 || node.id > this._id_counter) {
        throw new Error(message.failure);
    }

    // 2nd use-case: the first node is removed
    if (node.id === this.head.id) {
        // 2nd use-case: there is no second node
        if(node.id === this.tail.id) {
            this.tail = null;
        } else if (node.next.id == this.tail.id){ //there are only two nodes in the list
            this.tail = currentNode.next;
        }
        this.head = currentNode.next;

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

    return message.success;
};

DoublyList.prototype.upvote = function (nodeId) {
    var node = this.searchNodeById(nodeId);
    node.votes++;
    this.remove(node);
    this.add(node);
}

DoublyList.prototype.downvote = function (nodeId) {
    var node = this.searchNodeById(nodeId);
    node.votes--;
    this.remove(node);
    this.add(node);
}

Answer.prototype.printAnswer = function(questionId) {
    var answerDiv = document.createElement('div');

    answerDiv.className = 'answer';

    answerDiv.innerHTML =
        '<div class="answer" data-color="gray">\n' +
        '\t\t\t<div class="votes">\n' +
        '\t\t\t\t<div class="upvote" onclick="upvoteAnswer('+ questionId + "," + this.id + ')">\n' +
        '                </div>\n' +
        '\t\t\t\t<div class="number-of-votes">' + this.votes + '\n' +
        '                </div>\n' +
        '\t\t\t\t<div class="downvote" onclick="downvoteAnswer('+ questionId + "," + this.id + ')">\n' +
        '                </div>\n' +
        '\t\t\t</div>\n' +
        '\t\t\t<div class="question-and-answer">\n' +
        '\t\t\t\t<h2 style="color: #000000; direction: rtl;">' + this.data + '</h2>\n' +
        '\t\t\t\t<div style="text-align:center;">\n' +
        '\t\t\t\t</div>\n' +
        '\t\t\t</div>\n' +
        '\t\t</div>';

    return answerDiv;
}

Question.prototype.printAllAnswers = function() {

    var current = this.answers.head;

    var answers = document.createElement('div');

    answers.id = this.id;

    while(current) {
        answers.appendChild(current.printAnswer(this.id));
        current = current.next;
    }

    return answers;
}

Question.prototype.printQuestion = function() {
    var questDiv = document.createElement('div');

    questDiv.className = 'question';

    questDiv.innerHTML =
        '<div class="question" data-color="gray">\n' +
        '\t\t\t<div class="votes">\n' +
        '\t\t\t\t<div class="upvote" onclick="upvoteQuestion(' + this.id + ')">\n' +
        '                </div>\n' +
        '\t\t\t\t<div class="number-of-votes">' + this.votes + '\n' +
        '                </div>\n' +
        '\t\t\t\t<div class="downvote" onclick="downvoteQuestion(' + this.id + ')">\n' +
        '                </div>\n' +
        '\t\t\t</div>\n' +
        '\t\t\t<div class="question-and-answer">\n' +
        '\t\t\t\t<h2 style="color: #000000; direction: rtl;">' + this.data + '</h2>\n' +
        '\t\t\t\t<div style="text-align:center;">\n' +
        '\t\t\t\t\t<textarea id="textArea_' + this.id + '" type="answer" placeholder="הגב"></textarea>\n' +
        '\t\t\t\t\t<br>\n' +
        '\t\t\t\t\t<input type="submit" class="button2" name="action" id="upload_submit" value="answer" onClick="answerQuestion('+ this.id + ')"/>\n' +
        '\t\t\t\t</div>\n' +
        '\t\t\t</div>\n' +
        '\t\t</div>';

    var answers = this.printAllAnswers();

    questDiv.appendChild(answers);
    document.getElementById('questions').appendChild(questDiv);

    return questDiv;
}

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
}


function QuestionsList() {
}

QuestionsList.prototype = new DoublyList();


//////////// In page functions ///////////
var questions = new QuestionsList();

function askQuestion() {
    var textArea = document.getElementById("questionText");
    questions.addToTail(new Question(questions._id_counter, textArea.value));
    questions.printAllNodes();
}

function answerQuestion(id){
    var textArea = document.getElementById("textArea_" + id);
    var question = questions.searchNodeById(id);
    question.answers.addToTail(new Answer(question.answers._id_counter, textArea.value));
    questions.printAllNodes();
}

function upvoteQuestion(questionId) {
    questions.upvote(questionId);
    questions.printAllNodes();
}

function downvoteQuestion(questionId) {
    questions.downvote(questionId);
    questions.printAllNodes();
}

function upvoteAnswer(questionId, answerId) {
    var question = questions.searchNodeById(questionId);
    question.answers.upvote(answerId);
    questions.printAllNodes();
}

function downvoteAnswer(questionId, answerId) {
    var question = questions.searchNodeById(questionId);
    question.answers.downvote(answerId);
    questions.printAllNodes();
}

function saveForum(){
    var json = JSON.stringify(questions);

    var loc = window.location.pathname;
    var dir = loc.substring(0, loc.lastIndexOf('/'));

        $.ajax({
            url     : 'savejson.php',
            method  : 'post',
            data    : {'myJson' : json, 'path' : dir.toString()},
            dataType: json,
            success : function( response ) {
                alert( response );
            }
        });
}

function loadForum(){

    var loc = window.location.pathname;
    var dir = loc.substring(0, loc.lastIndexOf('/'));

    $.ajax({
        url: "forum.json",
        dataType: "json",
        success: function(response) {
            questions = JSON.parse(response);
        }
    });

    questions.printAllNodes();
}