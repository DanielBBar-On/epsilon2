var vue = new Vue({
  el: '#vue',
  data: {  
    questions: [
      {
        question: "איך הם הגיעו לפיתרון הזה?",
        answer: "בדרך הרגילה",
        votes: 7,
        searchTerms: "פתרון, אגברה, גבולות, ponies"
      },
      {
        question: "למה צריך להעלות בריבוע?",
        answer: "Its pretty dope.",
        votes: 4,
        searchTerms: "vue, js, javascript, ponies"
      },
      {
        question: "What is the circumference of the sun?",
        answer: "2,713,406 miles.",
        votes: 0,
        searchTerms: "miles, sun, circumference"
      },
      {
        question: "What date/time is it?",
        answer: new Date(),
        votes: -1,
        searchTerms: "date, day, time, hour, minute, time"
      },
      {
        question: "How much wood could a woodchuck chuck?",
        answer: "About 700 pounds.",
        votes: -3,
        searchTerms: "pounds, lbs, woodchuck, 700"
      }
    ],
    searchString: ""
  },

  methods: {
    vote: function(voteType, question) {
      if(voteType === "up") {
        question.votes++;

      } else if(voteType === "down") {
        if(question.votes <= -10) {
          return;
        }

        question.votes--;
      }
    },
    
    resetSearch: function() {
      this.searchString = "";
    }
  },

  filters: {
    voteColor: function(votes) {
      if(votes === 0) {
        votes = "gray";
      } else if(votes < 1) {
        votes = "red";
      } else if(votes >= 1 && votes <= 4) {
        votes = "yellow";
      } else if(votes >= 5) {
        votes = "green";
      }

      return votes;
    }
  }
});