package com.agecalculator.unittestingofagecalculator.service;

import org.junit.jupiter.api.Test;

import java.time.LocalDate;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertThrows;

public class AgeCalculatorTest {



    @Test
    void testValidAgeCalculation() {
        LocalDate birthDate = LocalDate.of(2000, 1, 1);
        assertEquals(25, AgeCalculator.calculateAge(birthDate));
    }

    @Test
    void testAgeCalculationOnBirthday() {
        LocalDate birthDate = LocalDate.now().minusYears(30);
        assertEquals(30, AgeCalculator.calculateAge(birthDate));
    }

    @Test
    void testLeapYearBirthdate() {
        LocalDate birthDate = LocalDate.of(2004, 2, 29);
        assertEquals(21, AgeCalculator.calculateAge(birthDate));
    }


    @Test
    void testCalculateAge_BirthdayTomorrow() {
        LocalDate dob = LocalDate.now().minusYears(25).plusDays(1);
        int age = AgeCalculator.calculateAge(dob);
        assertEquals(25, age);
    }

    @Test
    void testFutureBirthDate() {
        LocalDate futureDate = LocalDate.now().plusYears(1);
        Exception exception = assertThrows(IllegalArgumentException.class, () -> {
            AgeCalculator.calculateAge(futureDate);
        });
        assertEquals("Invalid Date of Birth", exception.getMessage());
    }



    @Test
    void testNullBirthDate() {
        Exception exception = assertThrows(IllegalArgumentException.class, () -> {
            AgeCalculator.calculateAge(null);
        });
        assertEquals("Invalid Date of Birth", exception.getMessage());
    }
}
