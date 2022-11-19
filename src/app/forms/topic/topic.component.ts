import { Component, OnInit} from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { ToastService } from 'angular-toastify';
import { TopicService } from './../../services/topic.service';
import { Router } from '@angular/router';
import { Subject, Observable, of } from 'rxjs';
import { Topic } from './../../models/topic.models';
import { ShareService } from './../../services/share.service';
import {Title} from '@angular/platform-browser';

@Component({
  selector: 'app-topic',
  templateUrl: './topic.component.html',
  styleUrls: ['./topic.component.css']
})
export class TopicComponent implements OnInit {
     form = new FormGroup({
            "title": new FormControl("", [Validators.required, Validators.minLength(5)]),
            "department": new FormControl("", [Validators.required, Validators.minLength(5)]),
            "faculty": new FormControl("", [Validators.required, Validators.minLength(5)]),
    });
    public error: any = []
    public subs: any;
  constructor(
       private topicService: TopicService,
       private share: ShareService,
       private loader: LoadingBarService,
       private toast: ToastService,
       private router: Router,
       private title: Title,
 ) {
      this.title.setTitle("Create a new topic")
 }

  ngOnInit(): void
  {
  }

  onSubmit()
  {
       this.loader.start()
       this.subs = this.topicService.create({title: this.form.value.title!, department: this.form.value.department!, faculty: this.form.value.faculty!}).subscribe(
            (response) => {
                 this.loader.complete()
                 this.toast.info(response.message)
                 this.error = []
                this.share.newTopicAdded.next({...this.form.value})
                this.form.reset()
            },
            (error) => {
                 this.loader.complete()
                 this.toast.warn(error.error.message)
                 this.error = error.error.errors
            }
       )
  }

  ngOnDestroy(): void {
       //Called once, before the instance is destroyed.
       //Add 'implements OnDestroy' to the class.
       if (this.subs) {
            this.subs.unsubscribe();
       }
  }
}
