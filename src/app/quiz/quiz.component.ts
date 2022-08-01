import { Component, OnInit } from '@angular/core';
import { PrepService } from '../Services/prep.service';
import { Router } from '@angular/router';
import { QuizService } from '../Services/quiz.service';
import { ToastService } from 'angular-toastify';
import { DomSanitizer, SafeResourceUrl, SafeUrl} from '@angular/platform-browser';

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
       private toast: ToastService,
       private sanitizer: DomSanitizer
 ) { }

     public questions: any = []
     public currentIndex = 0
     public stat: any = {completed: 0, total: 0, submitted: false}
     public timervalues: any = {minutes: 0, seconds: 0, currentTime: 0, ongoing: 0}
     public details = this.prep.getDetails();
     public german: any = {questions: '', answer: [], total: 0}
  ngOnInit(): void
  {
       const questions = this.prep.retrieveQuestions()
       if (questions == null || questions == undefined || questions == '') {
            this.router.navigate(['/prep'])
       }else{
            if (this.details.type == 'mcq') {
                 this.questions = this.prep.questions
                 this.stat.total = this.questions.length
                 this.questions[this.currentIndex].hidden = false
            }
            if (this.details.type == 'german') {
                 for (let index = 0; index < this.german.total; index++) {
                      let provided = {questionNumber: index+1, value: ''}
                      this.german.answer.push(provided)
                 }
                 this.german.question = this.sanitizer.bypassSecurityTrustHtml(this.german.question.replace(/\$\#\$\#\$\#/g, (match: any, offset: number, string: string) => {
                      return (offset > 0 ? '<input class="spans py-2 px-2 bg-gray-100 border-0 inline-block"/>' : '' )
                 }))
            }

            this.timervalues.currentTime = this.details.timer * 60
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
   submitGerman()
   {
        let spans = document.querySelectorAll('.spans')
        spans.forEach((element: any, index: number, arr) => {
             this.german.answer[index].value = element.innerText
        });
        console.log(this.german.answer)
        // Post the answer to the backend for marking
   }
}
