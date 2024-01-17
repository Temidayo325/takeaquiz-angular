import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';

import { LoadingBarModule } from '@ngx-loading-bar/core';
import { ToastService, AngularToastifyModule } from 'angular-toastify';
import { HttpClientModule, HTTP_INTERCEPTORS  } from '@angular/common/http';
// import { flowbite } from 'flowbite';

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
import { UserDashboardComponent } from './user/user-dashboard/user-dashboard.component';
import { AssessmentComponent } from './user/assessment/assessment.component';
import { ResultsComponent } from './user/results/results.component';
import { PrepComponent } from './user/prep/prep.component';
import { Error404Component } from './errors/error404/error404.component';
import { RegisterComponent } from './register/register.component';
import { VerifyAccountComponent } from './user/verify-account/verify-account.component';
import { AdminHomeComponent } from './admin/admin-home/admin-home.component';
import { UserHomeComponent } from './user/user-home/user-home.component';
import { LoaderComponent } from './components/loader/loader.component';
import { ConfirmComponent } from './components/confirm/confirm.component';
import { SuccessComponent } from './components/success/success.component';
import { RecoverPasswordComponent } from './user/recover-password/recover-password.component';
import { ChangePasswordComponent } from './forms/change-password/change-password.component';
import { SharedResultComponent } from './user/shared-result/shared-result.component';
import { ContentComponent } from './admin/content/content.component';
import { OutlineComponent } from './forms/outline/outline.component';
import { UserComponent } from './admin/user/user.component';
import { SkeletonModule } from 'primeng/skeleton';
import { CarouselModule } from 'primeng/carousel';
import { EditorModule } from 'primeng/editor';
import { DialogModule } from 'primeng/dialog';
// import { ButtonModule } from 'primeng/button';
// import { ConfirmDialogModule } from 'primeng/confirmdialog';
// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyCcUNSCsZ5W_VfE3p2rjxtAaa1hZUJ6Be4",
  authDomain: "quizly-86c7f.firebaseapp.com",
  projectId: "quizly-86c7f",
  storageBucket: "quizly-86c7f.appspot.com",
  messagingSenderId: "1040374552721",
  appId: "1:1040374552721:web:e01399f2012bf2db39c730",
  measurementId: "G-4E89JF06M5"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    HomeComponent,
    AdminLoginComponent,
    DashboardComponent,
    TopicComponent,
    QuestionComponent,
    VerifyQuestionComponent,
    UserDashboardComponent,
    AssessmentComponent,
    ResultsComponent,
    PrepComponent,
    Error404Component,
    RegisterComponent,
    VerifyAccountComponent,
    AdminHomeComponent,
    UserHomeComponent,
    LoaderComponent,
    ConfirmComponent,
    SuccessComponent,
    RecoverPasswordComponent,
    ChangePasswordComponent,
    SharedResultComponent,
    ContentComponent,
    OutlineComponent,
    UserComponent
  ],
  imports: [
    LoadingBarModule,
    BrowserModule,
    BrowserAnimationsModule,
    AppRoutingModule,
    ReactiveFormsModule,
    FormsModule,
    AngularToastifyModule,
    HttpClientModule,
    SkeletonModule,
    CarouselModule,
    EditorModule,
    DialogModule,
    // ConfirmDialogModule,
    // TableModule
    // ButtonModule
  ],
  providers: [ToastService],
  bootstrap: [AppComponent]
})
export class AppModule { }
