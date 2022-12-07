import { Component, OnInit  } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { LoadingBarService } from '@ngx-loading-bar/core';
import { ToastService } from 'angular-toastify';
import { StoreService } from './../../service/store.service';
import { ShareService } from './../../services/share.service';
import { UserService } from './../../service/user.service';
import { Router } from '@angular/router';
import {Title} from '@angular/platform-browser';

@Component({
  selector: 'app-user-home',
  templateUrl: './user-home.component.html',
  styleUrls: ['./user-home.component.css']
})
export class UserHomeComponent implements OnInit {

  constructor(
       private storeService: StoreService,
      private loader: LoadingBarService,
      private toast: ToastService,
      private router: Router,
      private userService: UserService,
      private title: Title,
      private shareService: ShareService,
 ) { }

  // public result: Array<[]> = JSON.parse(sessionStorage.getItem('results')!)
  public topTopics: Array<any> = JSON.parse(sessionStorage.getItem('top3Topics')!)
  public countedResult: number = sessionStorage.getItem('totalResults') === null ? 0 : Number(sessionStorage.getItem('totalResults'))
   public countedTopics: number = sessionStorage.getItem('totalTopics') === null ? 0 : Number(sessionStorage.getItem('totalTopics'))
  public topics: Array<any> = JSON.parse(sessionStorage.getItem('topics')!)
  public results: Array<any> = JSON.parse(sessionStorage.getItem('results')!)
  public user = JSON.parse(sessionStorage.getItem('user')!)

  ngOnInit(): void
  {
     this.title.setTitle('Your dashboard home')
     this.shareService.newHeader.next(`Hello ${this.user.nickname} !`)
  }
  trackByFn(index: number, result: any)
  {
        return result ? result.id : undefined;
  }
}
