import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ToastService } from 'angular-toastify';
import {Title} from '@angular/platform-browser';

@Component({
  selector: 'app-choose-assessment-status',
  templateUrl: './choose-assessment-status.component.html',
  styleUrls: ['./choose-assessment-status.component.css']
})
export class ChooseAssessmentStatusComponent implements OnInit {

  constructor(
       private router: Router,
       private toast: ToastService,
       private title: Title
 ) { }

  ngOnInit(): void
  {
       this.title.setTitle('Choose assessment status needs')
  }

  public chooseStatus(status: string):void
  {
      localStorage.setItem("isProffessional", status)
      this.toast.success("Your choice has been saved")
      setTimeout(() => {
           this.router.navigate(['/register'])
      }, 2000)
  }
}
