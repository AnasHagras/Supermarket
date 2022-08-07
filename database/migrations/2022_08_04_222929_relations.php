<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users',function (Blueprint $table){
            $table->unsignedBigInteger('employeeID')->nullable();
            $table->foreign('employeeID')->references('employeeID')->on('employees')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('invoices',function (Blueprint $table){
            $table->unsignedBigInteger('userID');
            $table->foreign('userID')->references('userID')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('products',function (Blueprint $table){
            $table->unsignedBigInteger('catagoryID');
            $table->foreign('catagoryID')->references('catagoryID')->on('catagories')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('companyID');
            $table->foreign('companyID')->references('companyID')->on('companies')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('receipts',function (Blueprint $table){
            $table->unsignedBigInteger('userID');
            $table->foreign('userID')->references('userID')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('invoice_products',function (Blueprint $table){
            $table->unsignedBigInteger('invoiceID');
            $table->foreign('invoiceID')->references('invoiceID')->on('invoices')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('barcode');
            $table->foreign('barcode')->references('barcode')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->index(['invoiceID','barcode']);
        });
        Schema::table('product_receipt_companies',function (Blueprint $table){
            $table->unsignedBigInteger('companyID');
            $table->foreign('companyID')->references('companyID')->on('companies')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('barcode');
            $table->foreign('barcode')->references('barcode')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('receiptID');
            $table->foreign('receiptID')->references('receiptID')->on('receipts')->onUpdate('cascade')->onDelete('cascade');
            $table->index(['receiptID','barcode','companyID']);
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
