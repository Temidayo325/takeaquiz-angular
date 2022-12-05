import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-success',
  templateUrl: './success.component.html',
  styleUrls: ['./success.component.css']
})
export class SuccessComponent implements OnInit {

  constructor() { }

  @Input() display: boolean = true
  @Input() text: string = "The action was a success"

  ngOnInit(): void {
  }
  closeModal()
  {
          this.display = false
  }
}
