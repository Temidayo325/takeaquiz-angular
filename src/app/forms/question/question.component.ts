import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { ToastService } from 'angular-toastify';
import { QuestionService } from './../../services/question.service';
import { Router } from '@angular/router';
import { Subject, Observable, of, Subscription } from 'rxjs';
// import { ShareService } from './../../services/share.service';

@Component({
  selector: 'app-question',
  templateUrl: './question.component.html',
  styleUrls: ['./question.component.css']
})
export class QuestionComponent implements OnInit {

     form = new FormGroup({
            "topic_id": new FormControl("", [Validators.required]),
            "question": new FormControl("", [Validators.required, Validators.minLength(4)]),
            "option1": new FormControl("", [Validators.required, Validators.minLength(4)]),
            "option2": new FormControl("", [Validators.required, Validators.minLength(4)]),
            "option3": new FormControl("", [Validators.nullValidator]),
            "option4": new FormControl("", [Validators.nullValidator]),
            "answer": new FormControl("", [Validators.required, Validators.minLength(4)]),
            "type": new FormControl("", [Validators.required, Validators.minLength(4)]),
    });
    public error: any = []
    public subs!: Subscription;
    public topics = JSON.parse(sessionStorage.getItem('topics')!)
    // public_
  constructor(
       private questionService: QuestionService,
       // private share: ShareService,
       private loader: LoadingBarService,
       private toast: ToastService,
       private router: Router,
 ) { }

  ngOnInit(): void
  {
       this.form.patchValue({type: "word"});
  }
  get question() { return this.form.get('question'); }
  get topic_id() { return this.form.get('topic_id'); }
  get option1() { return this.form.get('option1'); }
  get option2() { return this.form.get('option2'); }
  // get option3() { return this.form.get('option3'); }
  // get option4() { return this.form.get('option4'); }
  get answer() { return this.form.get('answer'); }

  onSubmit()
  {
       this.loader.start()
       const topic_id = this.form.value.topic_id
       this.subs = this.questionService.createFromForm({...this.form.value}).subscribe(
            (response: any) => {
                 this.loader.complete()
                 this.error = []
                this.form.reset()
                this.form.patchValue({type: "word", topic_id: topic_id})
            },
            (error: any) => {
                 this.loader.complete()
                 this.toast.warn(error.error.message)
                 this.error = error.error.errors
            }
       )
  }
  trackByFn(index: number, topic: any) {
        return topic ? topic.id : undefined;
    }
  ngOnDestroy(): void {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       if (this.subs) {
            this.subs.unsubscribe()
       }
  }
}
