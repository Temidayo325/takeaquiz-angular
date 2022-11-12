import { Component, OnInit, OnDestroy } from '@angular/core';
// import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { AssesmentService } from './../../service/assesment.service';
// import { StoreService } from './../../service/store.service';
import { Router, ActivatedRoute, ParamMap } from '@angular/router';
import { ToastService } from 'angular-toastify';
import { Subject, Observable, of } from 'rxjs';

@Component({
  selector: 'app-assessment',
  templateUrl: './assessment.component.html',
  styleUrls: ['./assessment.component.css']
})
export class AssessmentComponent implements OnInit, OnDestroy {

  constructor(
       private assesementService: AssesmentService,
      // private storeService: StoreService,
      private loader: LoadingBarService,
      private router: Router,
      private route: ActivatedRoute,
      private toast: ToastService
 ) { }

  questions: Array<any> = []
  duration: number = 0
  subs!: Subject<any>
  stat: any = {completed: 0, total: 0, submitted: false, correctScore: 0}
  timervalues: any = {minutes: 0, seconds: 0, currentTime: 0, ongoing: 0}
  currentIndex = 0

  ngOnInit(): void
  {
          this.loader.start()
          if (sessionStorage.getItem('questions') === null || sessionStorage.getItem('duration') === null) {
               this.router.navigate(['/user/dashboard/take-assessment'])
          }

          this.questions = JSON.parse(sessionStorage.getItem('questions')!)
          sessionStorage.setItem('questions', '')
          this.duration = parseInt(sessionStorage.getItem('duration')!)
          this.stat.total = this.questions.length
          this.questions[this.currentIndex].hidden = false

          // Timer function
          this.timervalues.currentTime = this.duration * 60
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
          this.loader.complete()
  }

  submit()
  {
       // Data to post {user_id: number, score: number, topic_id: number}
       this.loader.start()
       if (confirm("Are you sure you want to submit?")) {
            clearInterval(this.timervalues.ongoing)
            this.stat.submitted = true
            this.timervalues.ongoing = null
            const score = this.markTest()
            this.stat.correctScore = score
            const user = JSON.parse(sessionStorage.getItem('user')!)
            this.assesementService.submitAssesment({user_id: parseInt(user.id), score: score, topic_id:  Number(this.route.snapshot.paramMap.get('topic_id'))}).subscribe(
                 (response) => {
                      this.loader.complete()
                      sessionStorage.setItem('results', JSON.stringify(response.results))
                      setTimeout(() => {
                           this.router.navigate(['/user/dashboard/results'])
                      }, 5000)
                 },
                 (error) => {
                      this.loader.complete()
                      console.log(error)
                 }
            )
       }
  }

  markTest(): number
  {
       // Data to post {user_id: number, score: number, topic_id: number}
       let correctScore = 0
       this.questions.forEach((question, index) => {
          if (question.chosen != '' && question.answer.toLowerCase() == question.chosen.toLowerCase()) {
               correctScore += 1
          }
       });
       return correctScore
  }

  public timer()
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

   public trackByFn(index: any, item: any):number
  {
    return index;
  }

  public getCompleted()
  {
       let done = 0
       const completed = this.questions.forEach( (element: any ) => {
            if (element.chosen_answer !== '') {
                 done++
            }
       });
       this.stat.completed = done
  }
  public prev()
     {
          if (this.currentIndex > 0) {
               this.questions[this.currentIndex].hidden = true
               this.currentIndex -= 1
               this.questions[this.currentIndex].hidden = false
               this.getCompleted()
          }
     }
  public next()
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
  ngOnDestroy(): void {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       if (this.subs) {
            this.subs.unsubscribe()
       }
  }

}
