import { Component, OnInit } from '@angular/core';
import { PrepService } from '../Services/prep.service';
import { Router } from '@angular/router';
import { QuizService } from '../Services/quiz.service';
import { ToastService } from 'angular-toastify';

@Component({
  selector: 'app-quiz',
  templateUrl: './quiz.component.html',
  styleUrls: ['./quiz.component.scss']
})
export class QuizComponent implements OnInit {

  constructor(
       private prep: PrepService,
       private router: Router,
       private quiz: QuizService,
       private toast: ToastService
 ) { }
     // protected questions:  any = []
     public questions: any = [
       {chosen_answer: "", hidden: false, id: 3, option1: "Osinwin", option2: "Weyrey", option3: "Ode",
          option4: "Ashiere",  question: "Madman of the housess", type: "options"},
       {chosen_answer: "", hidden: true, id: 5, option1: "Osinwin", option2: "Weyrey", option3: "Ode",
          option4: "Ashiere", question: "Madman of the housesseeerrfffffff", type: "options"},
       {chosen_answer: "", hidden: true, id: 1, option1: "option 1", option2: "option 2", option3: "option 3",
          option4: "option 4", question: "Another question in the house", type: "options"},
       {chosen_answer: "", hidden: true, id: 6, option1: "True", option2: "False", option3: "option 3",
             option4: "option 4", question: "Another question in the house", type: "truthorfalse"}
     ]
     public currentIndex = 0
     public stat: any = {completed: 0, total: this.questions.length, submitted: false}
     public timervalues: any = {minutes: 0, seconds: 0, currentTime: 0, ongoing: 0}
     protected details = this.prep.getDetails();
  ngOnInit(): void
  {
       const questions = this.prep.retrieveQuestions()
       if (questions == null || questions == undefined || questions == '') {
            this.router.navigate(['/prep'])
       }else{
            this.questions = this.prep.questions
            this.timervalues.currentTime = this.details.timer * 60
            this.questions[this.currentIndex].hidden = false
            setTimeout(() => {
                 this.timervalues.ongoing = setInterval(() => {
                      this.timer()
                  }, 1000)
            }, 1000)
            let grace = 0
            document.addEventListener("visibilitychange", () => {
                if (document.visibilityState !== 'visible') {
                    this.toast.info("Your test has been submitted")
                    this.submit()
                }
            });
       }
  }
  submit()
  {
       if (confirm("Are you sure you want to submit?")) {
            clearInterval(this.timervalues.ongoing)
            this.timervalues.ongoing = null
            this.stat.submitted = true
            this.quiz.submitTest({questions: JSON.stringify(this.questions), matric: this.details.matric, display_token: this.details.display_token}).subscribe(
                 (res) => {
                      this.toast.info(res.message)
                      setTimeout(() => {
                           this.router.navigate(['prep'])
                      }, 10000)
                 },
                 (err) => {
                      this.toast.error(err.error.message)
                 }
            )
            // console.log(this.questions)
       }
  }
  prev()
  {
       if (this.currentIndex > 0) {
            this.questions[this.currentIndex].hidden = true
            this.currentIndex -= 1
            this.questions[this.currentIndex].hidden = false
            this.getCompleted()
       }
  }
  next()
  {
       if (this.currentIndex >= this.questions.length - 1) {
            this.questions[this.currentIndex].hidden = true
            this.currentIndex = 0
            this.questions[this.currentIndex].hidden = false
            this.getCompleted()
       }else{
             this.questions[this.currentIndex].hidden = true
             this.currentIndex += 1
             this.questions[this.currentIndex].hidden = false
             this.getCompleted()
       }

  }
  getCompleted()
  {
       let done = 0
       const completed = this.questions.forEach( (element: any ) => {
            if (element.chosen_answer !== '') {
                 done++
            }
       });
       this.stat.completed = done
  }
  timer()
  {
       this.timervalues.minutes = Math.floor(this.timervalues.currentTime / 60)
       this.timervalues.seconds  = (this.timervalues.currentTime % 60)
       this.timervalues.currentTime =  this.timervalues.currentTime - 1
       if (this.timervalues.minutes < 10) {
          this.timervalues.minutes = "0"+ this.timervalues.minutes
       }
       if (this.timervalues.seconds < 10) {
          this.timervalues.seconds = "0"+ this.timervalues.seconds
       }
       if (this.timervalues.currentTime > 0) {
          this.timervalues.currentTime = this.timervalues.currentTime - 1
       }else{
          clearInterval()
          this.submit()
       }
   }
}
