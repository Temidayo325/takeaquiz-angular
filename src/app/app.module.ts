import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule, HTTP_INTERCEPTORS  } from '@angular/common/http';
import { ToastService, AngularToastifyModule } from 'angular-toastify';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';
import { VerifyPasswordComponent } from './verify-password/verify-password.component';
import { RecoverPasswordComponent } from './recover-password/recover-password.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { ForgotPasswordComponent } from './forgot-password/forgot-password.component';
import { ChangePasswordComponent } from './change-password/change-password.component';
import { CourseComponent } from './course/course.component';
import { QuestionComponent } from './question/question.component';
// import { HttpErrorInterceptor } from './http-error.interceptor';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    HomeComponent,
    VerifyPasswordComponent,
    RecoverPasswordComponent,
    DashboardComponent,
    ForgotPasswordComponent,
    ChangePasswordComponent,
    CourseComponent,
    QuestionComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule,
    HttpClientModule,
    AngularToastifyModule
  ],
  providers: [
       // {
       //      provide: HTTP_INTERCEPTORS,
       //      useClass: HttpErrorInterceptor,
       //      multi: true
       // }
       ToastService
 ],
  bootstrap: [AppComponent]
})
export class AppModule { }
