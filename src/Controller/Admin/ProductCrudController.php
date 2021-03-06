<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return[
            TextField::new( propertyName:'name'),
            SlugField::new( propertyName:'slug')
            ->setTargetFieldName(fieldName:'name'),
            ImageField::new(propertyName:'Illustration')
            ->setBasePath(path:'public/uploads')
            ->setUploadDir(uploadDirPath:'public/uploads')
            ->setUploadedFileNamePattern(patternOrCallable:'[randomhash].[extension]')
            ->setRequired(isRequired:false),
            TextareaField::new(propertyName:'description'),
            BooleanField::new(propertyName:'isBest'),
            MoneyField::new(propertyName:'price')
            ->setCurrency(currencyCode:'EUR'),
            AssociationField::new(propertyName:'category')
        ];
    }
}
