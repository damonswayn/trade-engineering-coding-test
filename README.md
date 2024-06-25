# Catch - Trade Engineering Coding Test

## Overview

You will find two directories in this repository: `php` and `typescript`. Each directory contains a starting structure of a program that you will be required to complete. You have the choice of completing either the `php` version or the `typescript` version. You are not required to complete both.

## Task

A variety of special rules can be applied to a customer's Order which modify the final total to be paid.

You are given a simple implementation of a service (`OrderServiceImpl`) which takes a Cart object and performs the checking out
of the cart.

Your task is to add the core rules that have been identified below, and to ensure that further rules can be added with ease in the future.

### Core Rules

1. OnePass is an important product not just to Catch, but to the Wesfarmers group as a whole. As such, we need a rule that when a customer orders a product called "Membership Upgrade", the customers membership level is upgraded. However, a membership level cannot be upgraded beyond OnePass Premium.
2. The business offers both 'digital' and 'physical' products. If the customer orders a physical product, a shipping label should be generated (this can just be string with the customers name and address), and if a digital product is ordered, a download link should be generated (this can be a randomly generated fake URL).
3. If the customer orders a product with a category of 'Essentials', then they should not pay any tax on that item.
4. If the customer orders a product with a category of 'Luxury', then they should pay double the tax on that item.
5. If the customer is a OnePass member, they should receive a 10% discount on their order.
6. If the customer is a OnePass Premium member, they should receive a 20% discount on their order.
7. If the customer order more than $100 worth of products before tax, they should receive a 10% discount on their order.

### Advice

- Your work should be provably correct, think about how you would demonstrate that correctness.
- Think about how you can make your code easy to understand and maintain.
- We want to understand your thinking and problem-solving process.

### Rules

- ChatGPT, copilot and other AI tools are not allowed to be used.

### Submission

Please submit your completed code as a zip file, or a link to a private repository on GitHub, to your Catch contact.

If you require any special instructions for running your code, please include them in a README.md file in the root 
of your submission. Any complicated setup steps should be automatically runnable via a script (Makefile etc).
