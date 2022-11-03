import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';

import { LoadingBarModule } from '@ngx-loading-bar/core';
import { ToastService, AngularToastifyModule } from 'angular-toastify';
import { HttpClientModule, HTTP_INTERCEPTORS  } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { EffectsModule } from '@ngrx/effects';
import { HomeComponent } from './home/home.component';
import { AdminLoginComponent } from './admin-login/admin-login.component';
import { DashboardComponent } from './admin/dashboard/dashboard.component';
import { TopicComponent } from './forms/topic/topic.component';
import { QuestionComponent } from './forms/question/question.component';
import { VerifyQuestionComponent } from './admin/verify-question/verify-question.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    HomeComponent,
    AdminLoginComponent,
    DashboardComponent,
    TopicComponent,
    QuestionComponent,
    VerifyQuestionComponent
  ],
  imports: [
    LoadingBarModule,
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule,
    FormsModule,
    AngularToastifyModule,
    HttpClientModule
  ],
  providers: [ToastService],
  bootstrap: [AppComponent]
})
export class AppModule { }
