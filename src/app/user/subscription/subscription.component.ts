import { Component, OnInit } from '@angular/core';
import { ShareService } from './../../services/share.service';
import {Title} from '@angular/platform-browser';
// import PaystackPop from '@paystack/inline-js';

@Component({
  selector: 'app-subscription',
  templateUrl: './subscription.component.html',
  styleUrls: ['./subscription.component.css']
})
export class SubscriptionComponent implements OnInit {

  constructor(
       private title: Title,
      private shareService: ShareService,
 ) { }
  public mytime : string = ''
  public currentTime: Date = new Date()
  public user = JSON.parse(sessionStorage.getItem('user')!)
  public imageSource: string = `https://api.dicebear.com/7.x/initials/svg?seed=`+this.user.name

  ngOnInit(): void
  {
       this.title.setTitle('Your dashboard home')
       this.shareService.newHeader.next(`Hello ${this.user.nickname} !`)
       const today = new Intl.DateTimeFormat("en-US", {weekday: "long"}).format(this.currentTime)
       const day = (this.currentTime.getDate() < 10) ? '0'+this.currentTime.getDate() : this.currentTime.getDate()
       const month = (this.currentTime.getMonth() < 10) ? '0'+(this.currentTime.getMonth() + 1) : this.currentTime.getMonth() + 1
       this.mytime = `${today}, ${day} ${month} ${this.currentTime.getFullYear()}`
  }
  makePayment():void
  {

  }
}
