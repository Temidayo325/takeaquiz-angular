import { Component, OnInit } from '@angular/core';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { ToastService } from 'angular-toastify';
import { TopicService } from './../../services/topic.service';
import { Router } from '@angular/router';
import { Subject, Observable, of, Subscription } from 'rxjs';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { ShareService } from './../../services/share.service';
import { Title } from '@angular/platform-browser';
import { StoreService } from './../../service/store.service';

@Component({
  selector: 'app-verify-question',
  templateUrl: './verify-question.component.html',
  styleUrls: ['./verify-question.component.css']
})
export class VerifyQuestionComponent implements OnInit {
     form = new FormGroup({
            "topic_id": new FormControl("", [Validators.required]),
            "question_id": new FormControl("", [Validators.required]),
            "question": new FormControl("", [Validators.required, Validators.minLength(4)]),
            "option1": new FormControl("", [Validators.required, Validators.minLength(4)]),
            "option2": new FormControl("", [Validators.required, Validators.minLength(4)]),
            "option3": new FormControl("", [Validators.nullValidator]),
            "option4": new FormControl("", [Validators.nullValidator]),
            "answer": new FormControl("", [Validators.required, Validators.minLength(4)]),
            "type": new FormControl("", [Validators.required, Validators.minLength(4)]),
    });

  constructor(
       private topicService: TopicService,
       private share: ShareService,
       private loader: LoadingBarService,
       private toast: ToastService,
       private storeService: StoreService,
       private router: Router,
       private title: Title
 ) {
          this.title.setTitle("Verify questions")
     }
     public subs!: Subscription
     public questions: Array<any> = []
     public error: any = []
     public roles = this.storeService.getUserRoles()
     public topic: string = ''
     public showEditForm: any = {display: false, questionIndex: 0, question: {}}
     public topic_id: number = 0

  ngOnInit(): void
  {
       this.getData()

  }
  get question() { return this.form.get('question'); }
  get topicId() { return this.form.get('topic_id'); }
  get option1() { return this.form.get('option1'); }
  get option2() { return this.form.get('option2'); }
  get answer() { return this.form.get('answer'); }
  ngDoCheck()
  {
       // this.getData()
       // console.log('chande')
  }

  trackByFn(index: number, topic: any)
  {
        return topic ? topic.id : undefined;
  }

  toggleActivation(question_id: number, index: number, status: number)
  {
       this.loader.start()
       this.topicService.activateQuestion(question_id).subscribe(
            (response) => {
                 this.loader.complete()
                 this.toast.info("Question status updated")
                 this.questions[index].status = ( status === 0 ) ? 1 : 0
            },
            (error) => {
                 this.loader.complete()
                 this.toast.error(error.error.message)
            }
       )
  }

  public editQuestion(question_id: number,  question: any)
  {
       // create a new form and display the form
       this.loader.start()
       this.form.setValue({
            topic_id: `${this.topic_id}`,
            question_id: `${question_id}`,
            question: question.question,
            option1: question.option1,
            option2: question.option2,
            option3: question.option3,
            option4: question.option4,
            answer: question.answer,
            type: "word",
       });
       this.showEditForm.question = question
       this.showEditForm.display = true
       this.loader.complete()
  }
  public closeModal()
  {
      this.showEditForm.display = false
  }
  public submitEditForm()
  {
       this.loader.start()
       this.topicService.editQuestion({...this.form.value}).subscribe(
            (response) => {
                 this.loader.complete()
                 this.toast.info(response.message)
                this.error = []
                this.form.reset()
                const index = this.questions.indexOf(this.showEditForm.question)
                this.questions[index] = {...response.data, status: this.showEditForm.question.status}
                 this.showEditForm.display = false
            },
            (error) => {
                 this.loader.complete()
                 this.toast.warn(error.error.message)
                 this.error = error.error.errors
            }
       )
  }
  public getData()
  {
       this.loader.start()
       let index = this.router.url.split('/')
       this.topic_id = parseInt(index[4])
       this.topicService.getbyId(this.topic_id).subscribe(
            (response) => {
                 this.topic = response.data.topic.title
                 this.questions = response.data.questions
                 this.loader.complete()
                 this.toast.info(response.message)
            },
            (error) => {
                 this.topic = "Invalid topic requested"
                 this.toast.error(error.error.message)
            }
       )
  }

  ngOnDestroy(): void {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       if (this.subs) {
            this.subs.unsubscribe()
       }
  }
}
