import { Component, OnInit, OnDestroy } from '@angular/core';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { AssesmentService } from './../../service/assesment.service';
import { Router, ActivatedRoute, ParamMap } from '@angular/router';
import { ToastService } from 'angular-toastify';
import { Subject, Observable, of } from 'rxjs';
import {Title} from '@angular/platform-browser';
import { ShareService } from './../../services/share.service';
import { MarkedResult } from './../../models/uploadrresult.models';
import { LoaderComponent } from './../../components/loader/loader.component';
import { SuccessComponent } from './../../components/success/success.component';
// import { ConfirmComponent } from './../../components/confirm/confirm.component';

@Component({
  selector: 'app-assessment',
  templateUrl: './assessment.component.html',
  styleUrls: ['./assessment.component.css'],
  providers: []
})
export class AssessmentComponent implements OnInit, OnDestroy {

  constructor(
      private assesementService: AssesmentService,
      private title: Title,
      private loader: LoadingBarService,
      private router: Router,
      private route: ActivatedRoute,
      private toast: ToastService,
      private sharedService: ShareService
 ) {
          this.title.setTitle("Ongoing assessment")
          this.sharedService.newHeader.next("Assessment")
   }

  questions: Array<any> = []
  wrongQuestions: Array<any> = []
  duration: number = 0
  subs!: Subject<any>
  stat: any = {completed: 0, total: 0, submitted: false, correctScore: 0, submissionStatus: false, displayResult: false, question_ids: []}
  result: MarkedResult = {score: 0, grade: '', opinion: '', date: '', topic: ''}
  timervalues: any = {minutes: 0, seconds: 0, currentTime: 0, ongoing: 0}
  currentIndex = 0
  screen  = document.documentElement
  showLoader: boolean = false
  showSuccess: boolean = false
  showConfirm: boolean =  false
  priority: any = {yes: '', no: '', text: ''}
  confirmAction: any = {cancel: false, submit: false}
  topic_id: number = 0
  public user = JSON.parse(sessionStorage.getItem('user')!)
  private is_proffessional : Boolean = ( this.user.is_proffessional == 1 ) ? true : false;
  ngOnInit(): void
  {
          this.loader.start()
          // this.openFullscreen()
          if (sessionStorage.getItem('questions') === null || sessionStorage.getItem('duration') === null) {
               this.router.navigate(['/user/dashboard/take-assessment'])
          }

          this.questions = JSON.parse(sessionStorage.getItem('questions')!)
          this.questions.forEach((question, index) => {
               this.stat.question_ids.push(question.id)
          })
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
            // document.addEventListener("visibilitychange", () => {
            //     if (document.visibilityState !== 'visible') {
            //         this.toast.info("Your test has been submitted")
            //         if (!this.stat.submissionStatus) {
            //              this.submit()
            //         }
            //
            //     }
            // });
            //Get Topic Id
            this.topic_id = parseInt(sessionStorage.getItem("assessment_topic_id")!)
          this.loader.complete()
  }

  reject()
  {

  }

  accept()
  {

  }

  Confirm()
  {
       this.loader.start()
       if ( confirm("Are you sure you want to cancel ?") ) {
             sessionStorage.setItem('questions', '')
             this.loader.complete()
              this.router.navigate(['/user/dashboard/home'])
       }
  }

  confirmStatus(event: boolean)
  {
       this.showConfirm = false
       // Check if my action was to submit and user clicked yes on the confirm dialogue
       if (event && this.confirmAction.submit) {
            this.submit()
       }

       // Check if my action was to submit and user clicked yes on the confirm dialogue
       if (event && this.confirmAction.cancel) {
            sessionStorage.setItem('questions', '')
            setTimeout(() => {
                 this.router.navigate(['/user/dashboard/take-assessment'])
            }, 1000)
       }
  }

  initsubmission()
  {
       this.loader.start()
       if (confirm("Are you sure you want to submit your Assessment ?")) {
            this.loader.complete()
            this.submit()
       }
       this.loader.complete()
  }

  submit()
  {
       this.loader.start()
       this.showLoader = true
       clearInterval(this.timervalues.ongoing)
       this.stat.submitted = true
       this.timervalues.ongoing = null
       const score = this.markTest()
       // this.closeFullscreen()
       this.stat.correctScore = score
       const user = JSON.parse(sessionStorage.getItem('user')!)
       this.assesementService.submitAssesment({user_id: parseInt(user.id), score: score, topic_id:  this.topic_id, proffessional_status: this.is_proffessional, question_ids : JSON.stringify(this.stat.question_ids )}).subscribe(
            (response) => {
                 this.loader.complete()
                 // this.toast.info(response.message)
                 this.stat.submissionStatus = true
                 sessionStorage.setItem('results', JSON.stringify(response.results))
                 this.toast.success("Assessement result marked and saved succesfully")
                 this.showLoader = false
                 if(this.is_proffessional)
                 {
                      console.log(this.wrongQuestions)
                      this.questions = this.wrongQuestions;
                      this.stat.displayResult = true
                      this.result = response.recent_result
                      this.showSuccess = false
                 }else{

                      this.showSuccess = true
                      setTimeout(() => {
                           this.showSuccess = false
                           this.router.navigate(['/user/dashboard/results'])
                      }, 3000)
                 }
                 this.loader.complete()
            },
            (error) => {
                 this.loader.complete()
                 this.toast.error(error.message)
                 console.log(error)
            }
       )
  }

  markTest(): number
  {
       // Data to post {user_id: number, score: number, topic_id: number}
       let correctScore = 0
       this.questions.forEach((question, index) => {
          if (question.chosen != '' && question.answer.toLowerCase() == question.chosen.toLowerCase()) {
               correctScore += 1
          }else{
               this.wrongQuestions.push(question)
          }
       });
       return correctScore
  }

  startReview()
  {
       this.stat.displayResult = false;
       this.stat.submissionStatus = true
       this.stat.submitted = false
  }

  redirect():void
  {
       this.router.navigate(['/user/dashboard/results'])
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

     openFullscreen()
     {
            if (this.screen.requestFullscreen) {
              this.screen.requestFullscreen();
             }
      }

      closeFullscreen()
     {
            if (document.exitFullscreen) {
                 document.exitFullscreen();
             }
      }

  ngOnDestroy(): void
  {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       if (this.subs) {
            this.subs.unsubscribe()
       }
  }

}
