package com.agecalculator.unittestingofagecalculator.service;

import java.time.LocalDate;
import java.time.Period;

public class AgeCalculator {

    public static int calculateAge(LocalDate birthDate) {
        if (birthDate == null || birthDate.isAfter(LocalDate.now())) {
            throw new IllegalArgumentException("Invalid Date of Birth");
        }
        return Period.between(birthDate, LocalDate.now()).getYears();
    }


}
