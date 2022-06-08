import { Component, OnInit } from '@angular/core';
import { ComplaintService } from '../Services/complaint.service';
import { ToastService } from 'angular-toastify';

@Component({
  selector: 'app-complaints',
  templateUrl: './complaints.component.html',
  styleUrls: ['./complaints.component.scss']
})
export class ComplaintsComponent implements OnInit {

  constructor(
       private complaint: ComplaintService,
       private toast: ToastService
 ) { }
   public complaints: any = []
  ngOnInit(): void
  {
       this.complaint.getActiveComplaints().subscribe(
            (res) => {
                 res.complaints.forEach( (element: any) => {
                      this.complaints.push( ...element)
                 });
            },
            (err) => {
                 console.log(err)
            }
       )
  }
  completed(complaint: any)
  {
       this.complaint.deactivate({id: complaint.id}).subscribe(
            (res) => {
                 const index = this.complaints.indexOf(complaint)
                 this.complaints.splice(index, 1)
                 this.toast.info(res.message)
            },
            (err) => {
                 this.toast.warn(err.error.message)
            }
       )
  }
}
